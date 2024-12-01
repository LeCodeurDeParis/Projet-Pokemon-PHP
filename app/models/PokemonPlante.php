<?php

    require_once 'Pokemon.php';
    require_once 'Attaque.php';

    class PokemonPlante extends Pokemon{
        public string $type = "Plante";

        public function __construct($nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
            parent::__construct($nom, $this->type, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire, Attaque $attaque){
            $attaque->executerAttaque($this, $adversaire);
        }
    }
?>