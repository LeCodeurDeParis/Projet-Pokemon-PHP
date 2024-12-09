<?php

    class Attaque{
        protected ?int $id;
        protected ?string $nom;
        protected ?string $type;
        protected ?int $puissance;
        protected ?int $precision;
        
        public function __construct($id = null, $nom = null, $type = null, $puissance = null, $precision = null)
        {
            $this->id = $id;
            $this->nom = $nom;
            $this->type = $type;
            $this->puissance = $puissance;
            $this->precision = $precision;
        }

        
        public function executerAttaque($attaquant, $adversaire)
        {
            $chance = rand(1, 100);
            if ($chance <= $this->precision) {
                $efficacite = $this->calculerEfficacite($attaquant->type, $adversaire->type);

                $degats = round((($this->puissance * $attaquant->puissanceAttaque *2) / $adversaire->defense/2)*$efficacite);
                if ($degats < 0) {
                    $degats = 0;
                }

                $_SESSION['messages'][] = $attaquant->nom . " utilise " . $this->nom . " sur " . $adversaire->nom . " !";
                $adversaire->recevoirDegats($degats);                
            } else {
                $_SESSION['messages'][] = $attaquant->nom . " utilise " . $this->nom . " sur mais cela échoue !";
            }
        }

        public function calculerEfficacite($typeAttaquant, $typeAdversaire)
        {
            $tableEfficacite = [
                'Feu' => ['Feu' => 1, 'Plante' => 2, 'Eau' => 0.5],
                'Eau' => ['Eau' => 1, 'Feu' => 2, 'Plante' => 0.5],
                'Plante' => ['Plante' => 1, 'Eau' => 2, 'Feu' => 0.5]
            ];
            return $tableEfficacite[$typeAttaquant][$typeAdversaire] ?? 1;
        }


        public function getNom()
        {
            return $this->nom;
        }

        public function getID()
        {
            return $this->id;
        }
    }

?>
