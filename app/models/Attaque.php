<?php

    class Attaque{
        // Déclaration des propriétés
        protected ?int $id;
        protected ?string $nom;
        protected ?string $type;
        protected ?int $puissance;
        protected ?int $precision;
        
        // Constructeur de la classe
        public function __construct($id = null, $nom = null, $type = null, $puissance = null, $precision = null)
        {
            $this->id = $id;
            $this->nom = $nom;
            $this->type = $type;
            $this->puissance = $puissance;
            $this->precision = $precision;
        }

        // Méthode pour exécuter l'attaque
        public function executerAttaque($attaquant, $adversaire)
        {
            // Générer une chance aléatoire
            $chance = rand(1, 100);
            // Vérifier si l'attaque réussit en fonction de la précision
            if ($chance <= $this->precision) {
                // Calculer l'efficacité de l'attaque en fonction des types
                $efficacite = $this->calculerEfficacite($attaquant->type, $adversaire->type);

                // Calculer les dégâts infligés
                $degats = round((($this->puissance * $attaquant->puissanceAttaque *2) / $adversaire->defense/2)*$efficacite);
                if ($degats < 0) {
                    $degats = 0;
                }

                $_SESSION['messages'][] = $attaquant->nom . " utilise " . $this->nom . " sur " . $adversaire->nom . " !";
                // Infliger les dégâts à l'adversaire
                $adversaire->recevoirDegats($degats);                
            } else {
                $_SESSION['messages'][] = $attaquant->nom . " utilise " . $this->nom . " sur mais cela échoue !";
            }
        }

        // Méthode pour calculer l'efficacité de l'attaque en fonction des types
        public function calculerEfficacite($typeAttaquant, $typeAdversaire)
        {
            // Tableau d'efficacité des types
            $tableEfficacite = [
                'Feu' => ['Feu' => 1, 'Plante' => 2, 'Eau' => 0.5],
                'Eau' => ['Eau' => 1, 'Feu' => 2, 'Plante' => 0.5],
                'Plante' => ['Plante' => 1, 'Eau' => 2, 'Feu' => 0.5]
            ];
            // Retourner l'efficacité en fonction des types
            return $tableEfficacite[$typeAttaquant][$typeAdversaire] ?? 1;
        }

        // Méthode pour obtenir le nom de l'attaque
        public function getNom()
        {
            return $this->nom;
        }

        // Méthode pour obtenir l'ID de l'attaque
        public function getID()
        {
            return $this->id;
        }
    }

?>
