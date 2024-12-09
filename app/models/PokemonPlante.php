<?php

    class PokemonPlante extends Pokemon{
        public const TYPE = "Plante";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire){
            //Fouet-Liane
            $power = 90;
            if ($adversaire->type == "Eau") {
                $power *= 2;
            } elseif ($adversaire->type == "Feu") {
                $power = round($power * 0.5);
            }
            $_SESSION['messages'][] = $this->nom . " utilise Fouet-Liane sur " . $adversaire->nom . " !";
            $adversaire->recevoirDegats($power);
        }
    }
?>