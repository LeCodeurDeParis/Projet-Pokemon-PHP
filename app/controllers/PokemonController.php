<?php

    class PokemonController {
        public function choose() {
            $model = new PokemonModel();
            // Récupération de tous les Pokémon via le modèle
            $pokemons = $model->findAll();
            // Inclure la vue pour afficher les Pokémon
            require_once __DIR__ . '/../views/allPokemons.php';
        }
    }
    
?>