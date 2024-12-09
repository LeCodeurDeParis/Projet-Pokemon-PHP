<?php

    class PokemonModel extends BDD{

        public function __construct(){
            parent::__construct();
        }

        public function findAll(): array {
            try {
                $pokemons = $this->getConnection()->prepare('SELECT * FROM allpokemon');
                $pokemons->execute();
                return $pokemons->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Gérer l'erreur (log, message utilisateur, etc.)
                die('Erreur lors de la récupération des Pokémon : ' . $e->getMessage());
            }
        }

        public function findOneById(int $id): array {
            try {
                $query = $this->getConnection()->prepare('SELECT * FROM allpokemon WHERE id = :id');
                $query->execute(['id' => $id]);
                $query->setFetchMode(PDO::FETCH_ASSOC);
                return $query->fetch();
            } catch (PDOException $e) {
                die('Erreur lors de la récupération d\'un Pokémon : ' . $e->getMessage());
            }
        }
        
        public function findPokemonWithAttacks(int $id): Pokemon {
            try {
                $query = $this->getConnection()->prepare('
                    SELECT p.*, a.id AS attaque_id, a.nom AS attaque_nom, a.puissance, a.precision
                    FROM allpokemon p
                    LEFT JOIN pokemonattaques pa ON pa.pokemon_id = p.id
                    LEFT JOIN allattaques a ON a.id = pa.attaque_id
                    WHERE p.id = :id
                ');
                $query->execute(['id' => $id]);
        
                $rows = $query->fetchAll(PDO::FETCH_ASSOC);
                if (empty($rows)) {
                    throw new Exception("Aucun Pokémon trouvé avec l'ID $id");
                }
        
                // Déterminer la classe concrète en fonction du type du Pokémon
                $type = strtolower($rows[0]['type']);
                $className = "Pokemon" . ucfirst($type);
        
                if (!class_exists($className)) {
                    throw new Exception("Classe pour le type '$type' introuvable");
                }
        
                // Instancier le Pokémon
                $pokemon = new $className(
                    $rows[0]['nom'],
                    $rows[0]['pointsDeVie'],
                    $rows[0]['puissanceAttaque'],
                    $rows[0]['defense'],
                    $rows[0]['vitesse']
                );
        
                // Ajouter les attaques
                foreach ($rows as $row) {
                    if (!empty($row['attaque_id'])) {
                        $attaque = new Attaque(
                            $row['attaque_nom'],
                            $row['puissance'],
                            $row['precision']
                        );
                        $pokemon->ajouterAttaque($attaque);
                    }
                }
        
                return $pokemon;
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        public function findRandomWithoutId(int $id): array {
            try {
                $query = $this->getConnection()->prepare('SELECT * FROM allpokemon WHERE id != :id ORDER BY RAND() LIMIT 1');
                $query->execute(['id' => $id]);
                return $query->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erreur lors de la récupération d\'un Pokémon aléatoire : ' . $e->getMessage());
            }
        }

        public function getAttaquesByPokemonID(int $id): array{
            $query = $this->getConnection()->prepare('SELECT * FROM `allattaques` INNER JOIN pokemonattaques ON attaque_id = id WHERE pokemon_id = :id;');
            $query->execute(array('id' => $id));
            return array_map(function($attaque){
                return new Attaque($attaque['id'], $attaque['nom'], $attaque['type'], $attaque['puissance'], $attaque['precision']);
            }, $query->fetchAll(PDO::FETCH_ASSOC));
        }
    }

?>