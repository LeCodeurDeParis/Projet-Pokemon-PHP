<?php
    interface InterfaceCombattant{
        public function seBattre(InterfaceCombattant $adversaire, Attaque $attaque): void;
        public function utiliserAttaqueSpeciale(InterfaceCombattant $adversaire): void;
    }

?>