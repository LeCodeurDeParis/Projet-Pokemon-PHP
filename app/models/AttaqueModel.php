<?php

    class AttaqueModel extends BDD {

        public function __construct() {
            parent::__construct();
        }

        public function isLinkedToPokemon($id, $pokemonId)
        {
            $query = $this->getConnection()->prepare('SELECT * FROM `pokemonattaques` WHERE attaque_id = :id AND pokemon_id = :pokemon_id');
            $query->execute(['id' => $id, 'pokemon_id' => $pokemonId]);
            return null != $query->fetch(PDO::FETCH_ASSOC);
        }

        public function findOneByIdLinkedToPokemon($id, $ID_pokemon): Attaque {
            $query = $this->getConnection()->prepare('
                SELECT a.*
                FROM allattaques a
                INNER JOIN pokemonattaques pa ON pa.attaque_id = a.id
                WHERE pa.pokemon_id = :pokemon_id AND a.id = :id
            ');
            $query->execute(['id' => $id , 'pokemon_id' => $ID_pokemon]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            return new Attaque($data['id'], $data['nom'], $data['type'], $data['puissance'], $data['precision']);
        }

    }

?>