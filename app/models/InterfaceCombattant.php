<?php
    // Déclaration de l'interface
    interface InterfaceCombattant{
        // Déclaration des méthodes
        public function seBattre(InterfaceCombattant $adversaire, Attaque $attaque): void;
        public function utiliserAttaqueSpeciale(InterfaceCombattant $adversaire): void;
    }

?>