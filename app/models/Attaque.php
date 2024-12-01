<?php

    class Attaque{
        protected string $nom;
        protected int $puissance;
        protected int $precision;
        
        public function __construct($nom, $puissance, $precision)
        {
            $this->nom = $nom;
            $this->puissance = $puissance;
            $this->precision = $precision;
        }

        
        public function executerAttaque($attaquant, $adversaire)
        {
            $chance = rand(1, 100);
            if ($chance <= $this->precision) {
                $efficacite = $this->calculerEfficacite($attaquant->type, $adversaire->type);

                $degats = ($this->puissance * $efficacite) - ($adversaire->defense/2);

                echo "<br>";

                $adversaire->recevoirDegats($degats);

                
            } else {
                echo $this->nom . " échoue et ne touche pas l'adversaire !<br>";
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
    }

?>
