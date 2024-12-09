<?php

    // Déclaration de la classe PokemonEau qui hérite de la classe abstraite Pokemon
    class PokemonFeu extends Pokemon{
        public const TYPE = "Feu";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {   // Appel du constructeur de la classe parente avec le type "Feu"
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire){
            // Définir la puissance de l'attaque Lance-Flamme
            $power = 90;
            // Ajuster la puissance en fonction du type de l'adversaire
            if ($adversaire->type == "Plante") {
                $power *= 2;
            } elseif ($adversaire->type == "Eau") {
                $power = round($power * 0.5);
            }
            $_SESSION['messages'][] = $this->nom . " utilise Lance-Flamme sur " . $adversaire->nom . " !";
            //Infliger les dégâts à l'adversaire
            $adversaire->recevoirDegats($power);
        }
    }
?>