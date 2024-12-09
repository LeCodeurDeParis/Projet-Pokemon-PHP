<?php

    // Déclaration de la classe PokemonModel qui hérite de la classe BDD
    class PokemonModel extends BDD{

        public function __construct(){
            parent::__construct();
        }

        // Méthode pour récupérer tous les Pokémon
        public function findAll(): array {
            try {
                // Préparer et exécuter la requête SQL pour récupérer tous les Pokémon
                $pokemons = $this->getConnection()->prepare('SELECT * FROM allpokemon');
                $pokemons->execute();
                // Retourner les résultats sous forme de tableau associatif
                return $pokemons->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Gérer l'erreur (log, message utilisateur, etc.)
                die('Erreur lors de la récupération des Pokémon : ' . $e->getMessage());
            }
        }

        // Méthode pour récupérer un Pokémon par son ID
        public function findOneById(int $id): array {
            try {
                // Préparer et exécuter la requête SQL pour récupérer un Pokémon par son ID
                $query = $this->getConnection()->prepare('SELECT * FROM allpokemon WHERE id = :id');
                $query->execute(['id' => $id]);
                $query->setFetchMode(PDO::FETCH_ASSOC);
                // Retourner le résultat sous forme de tableau associatif
                return $query->fetch();
            } catch (PDOException $e) {
                die('Erreur lors de la récupération d\'un Pokémon : ' . $e->getMessage());
            }
        }
        
        // Méthode pour récupérer un Pokémon avec ses attaques par son ID
        public function findPokemonWithAttacks(int $id): Pokemon {
            try {
                // Préparer et exécuter la requête SQL pour récupérer un Pokémon avec ses attaques
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
                    $rows[0]['id'],
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
                            $row['attaque_id'],
                            $row['attaque_nom'],
                            $row['type'],
                            $row['puissance'],
                            $row['precision']
                        );
                        $pokemon->attaques[] = $attaque;
                    }
                }

                return $pokemon;
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        // Méthode pour récupérer un Pokémon aléatoire sans un ID spécifique
        public function findRandomWithoutId(int $id): array {
            try {
                // Préparer et exécuter la requête SQL pour récupérer un Pokémon aléatoire sans un ID spécifique
                $query = $this->getConnection()->prepare('SELECT * FROM allpokemon WHERE id != :id ORDER BY RAND() LIMIT 1');
                $query->execute(['id' => $id]);
                // Retourner le résultat sous forme de tableau associatif
                return $query->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die('Erreur lors de la récupération d\'un Pokémon aléatoire : ' . $e->getMessage());
            }
        }

        // Méthode pour récupérer les attaques d'un Pokémon par son ID
        public function getAttaquesByPokemonID(int $id): array {
            // Préparer et exécuter la requête SQL pour récupérer les attaques d'un Pokémon
            $query = $this->getConnection()->prepare('SELECT * FROM `allattaques` INNER JOIN pokemonattaques ON attaque_id = id WHERE pokemon_id = :id;');
            $query->execute(['id' => $id]);
            // Retourner les résultats sous forme de tableau d'instances de la classe Attaque
            return array_map(function($attaque) {
                return new Attaque($attaque['id'], $attaque['nom'], $attaque['type'], $attaque['puissance'], $attaque['precision']);
            }, $query->fetchAll(PDO::FETCH_ASSOC));
        }
    }

?>