<?php

    // Déclaration de la classe PokemonEau qui hérite de la classe abstraite Pokemon
    class PokemonEau extends Pokemon{
        public const TYPE = "Eau";

        public function __construct($id, $nom, $pointsDeVie, $puissanceAttaque, $defense, $vitesse)
        {
             // Appel du constructeur de la classe parente avec le type "Eau"
            parent::__construct($id, $nom, static::TYPE, $pointsDeVie, $puissanceAttaque, $defense, $vitesse);
        }
        
        // Méthode pour utiliser la capacité spéciale du Pokémon Eau
        public function capaciteSpeciale(Pokemon $adversaire){
            // Définir la puissance de l'attaque Hydrocanon
            $power = 90;
            // Ajuster la puissance en fonction du type de l'adversaire
            if ($adversaire->type == "Feu") {
                $power *= 2;
            } elseif ($adversaire->type == "Plante") {
                $power = round($power * 0.5);
            }
            $_SESSION['messages'][] = $this->nom . " utilise Hydrocanon sur " . $adversaire->nom . " !";
            // Infliger les dégâts à l'adversaire
            $adversaire->recevoirDegats($power);
        }
    }
?>