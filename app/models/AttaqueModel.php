<?php

    // Déclaration de la classe AttaqueModel qui hérite de la classe BDD
    class AttaqueModel extends BDD {

        // Constructeur de la classe
        public function __construct() {
            // Appel du constructeur de la classe parente
            parent::__construct();
        }

        // Méthode pour vérifier si une attaque est liée à un Pokémon
        public function isLinkedToPokemon($id, $pokemonId)
        {   
            // Préparation de la requête
            $query = $this->getConnection()->prepare('SELECT * FROM `pokemonattaques` WHERE attaque_id = :id AND pokemon_id = :pokemon_id');
            $query->execute(['id' => $id, 'pokemon_id' => $pokemonId]);
            // Retourne vrai si l'attaque est liée au Pokémon sinon faux
            return null != $query->fetch(PDO::FETCH_ASSOC);
        }

        // Méthode pour trouver une attaque par son ID et vérifier qu'elle est liée à un Pokémon
        public function findOneByIdLinkedToPokemon($id, $ID_pokemon): Attaque {
            // Préparation de la requête
            $query = $this->getConnection()->prepare('
                SELECT a.*
                FROM allattaques a
                INNER JOIN pokemonattaques pa ON pa.attaque_id = a.id
                WHERE pa.pokemon_id = :pokemon_id AND a.id = :id
            ');
            $query->execute(['id' => $id , 'pokemon_id' => $ID_pokemon]);
            // Récupération des données de l'attaque
            $data = $query->fetch(PDO::FETCH_ASSOC);
            // Retourner une instance de la classe Attaque avec les données récupérées
            return new Attaque($data['id'], $data['nom'], $data['type'], $data['puissance'], $data['precision']);
        }

    }

?>