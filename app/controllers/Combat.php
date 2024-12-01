<?php
    require_once 'Pokemon.php';
    require_once '../models/InterfacesCombattants.php';
    class Combat implements InterfacesCombattants{
        public Pokemon $pokemon1;
        public Pokemon $pokemon2;

       public function __construct(Pokemon $pokemon1, Pokemon $pokemon2){
           $this->pokemon1 = $pokemon1;
           $this->pokemon2 = $pokemon2;
       }

       public function seBattre(){
           while(!$this->pokemon1->estKO() && !$this->pokemon2->estKO()){
               $this->tourDeCombat($this->pokemon1, $this->pokemon2);
               if ($this->pokemon2->estKO()) break;
               $this->tourDeCombat($this->pokemon2, $this->pokemon1);
                
            }

           $this->determinerVainqueur();
        }

       public function tourDeCombat(Pokemon $attaquant, Pokemon $defenseur){
            $attaque = $attaquant->attaques[0];
            $attaquant->attaquer(0, $defenseur);
       }

       public function determinerVainqueur(){
           if($this->pokemon1->estKO()){
               echo $this->pokemon2->nom . " a gagné !";
           }else{
               echo $this->pokemon1->nom . " a gagné !";
           }
       }

    }
?>