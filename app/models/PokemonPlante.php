<?php

    // Déclaration de la classe PokemonPlante qui hérite de la classe abstraite Pokemon
    class PokemonPlante extends Pokemon{
        public const TYPE = "Plante";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
            // Appel du constructeur de la classe parente avec le type "Plante"
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
    
        public function capaciteSpeciale(Pokemon $adversaire){
            // Définir la puissance de l'attaque Fouet-Liane
            $power = 90;
            // Ajuster la puissance en fonction du type de l'adversaire
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