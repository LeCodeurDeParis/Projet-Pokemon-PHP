<?php

    class PokemonFeu extends Pokemon{
        public const TYPE = "Feu";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire){
            //Lance-Flamme
            $power = 90;
            if ($adversaire->type == "Plante") {
                $power *= 2;
            } elseif ($adversaire->type == "Eau") {
                $power = round($power * 0.5);
            }
            $_SESSION['messages'][] = $this->nom . " utilise Lance-Flamme sur " . $adversaire->nom . " !";
            $adversaire->recevoirDegats($power);
        }
    }
?>