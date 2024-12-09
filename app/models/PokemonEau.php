<?php

    class PokemonEau extends Pokemon{
        public const TYPE = "Eau";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire){
            //Hydrocanon
            $power = 90;
            if ($adversaire->type == "Feu") {
                $power *= 2;
            } elseif ($adversaire->type == "Plante") {
                $power = round($power * 0.5);
            }
            $_SESSION['messages'][] = $this->nom . " utilise Hydrocanon sur " . $adversaire->nom . " !";
            $adversaire->recevoirDegats($power);
        }
    }
?>