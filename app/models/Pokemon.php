<?php

    abstract class Pokemon{
        public string $nom;
        public string $type;
        public int $pointsDeVie;
        public int $pointsDeVieMax;
        public int $puissanceAttaque;
        public int $defense;
        public int $vitesse;
        public array $attaques = [];

        public function __construct($nom, $type, $pointsDeVie, $puissanceAttaque, $defense, $vitesse){
            $this->nom = $nom;
            $this->type = $type;
            $this->pointsDeVie = $pointsDeVie;
            $this->pointsDeVieMax = $pointsDeVie;
            $this->puissanceAttaque = $puissanceAttaque;
            $this->defense = $defense;
            $this->vitesse = $vitesse;
        }

        public function ajouterAttaque(Attaque $attaque){
            $this->attaques[] = $attaque;
        }

        public function attaquer($indexAttaque, $adversaire){
            echo $this->nom . " utilise " . $this->attaques[$indexAttaque]->getNom() . " !<br>";

            $this->capaciteSpeciale($adversaire, $this->attaques[$indexAttaque]);
        }

        public function recevoirDegats($degats){
            $this->pointsDeVie -= $degats;
            if ($this->pointsDeVie < 0) {
                $this->pointsDeVie = 0;
            }
            echo $this->nom . " reçoit " . $degats . " points de dégats. " . $this->nom . " a maintenant " . $this->pointsDeVie . " points de vie. <br>";
        }

        public function estKO(){
            if($this->pointsDeVie <= 0){
                return true;
            }else{
                return false;
            }
        }

        abstract public function capaciteSpeciale(Pokemon $adversaire, Attaque $attaque);
    }

?>