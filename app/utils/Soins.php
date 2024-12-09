<?php

    // Déclaration du trait Soins
    trait Soins {
        // Méthode pour soigner le Pokémon
        public function soigner() {
            // Restaurer les points de vie du Pokémon à leur valeur maximale
            $this->pointsDeVie = $this->pointsDeVieMax;
        }
    }

?>