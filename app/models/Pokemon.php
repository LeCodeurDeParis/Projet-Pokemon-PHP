<?php

    abstract class Pokemon implements InterfaceCombattant{
        public int $id;
        public string $nom;
        public string $type;
        public int $pointsDeVie;
        public int $pointsDeVieMax;
        public int $puissanceAttaque;
        public int $defense;
        public int $vitesse;
        public array $attaques = [];

        use Soins;

        public function __construct($id, $nom, $type, $pointsDeVie, $puissanceAttaque, $defense, $vitesse){
            $this->id = (int) $id;
            $this->nom = $nom;
            $this->type = $type;
            $this->pointsDeVie = (int) $pointsDeVie;
            $this->pointsDeVieMax = (int) $pointsDeVie;
            $this->puissanceAttaque = (int) $puissanceAttaque;
            $this->defense = (int) $defense;
            $this->vitesse = (int) $vitesse;
        }

        public function recevoirDegats($degats){
            $this->pointsDeVie -= (int) $degats;
            if ($this->pointsDeVie < 0) {
                $this->pointsDeVie = 0;
            }
            $_SESSION['messages'][] = $this->nom . " reçoit " . $degats . " points de dégâts. " . $this->nom . " a maintenant " . $this->pointsDeVie . " points de vie.";
        }

        public function estKO(){
            if($this->pointsDeVie <= 0){
                return true;
            }else{
                return false;
            }
        }

        public function seBattre(InterfaceCombattant $adversaire, Attaque $attaque): void{
            if ((new AttaqueModel)->isLinkedToPokemon($attaque->getID(), $this->id)) {

                $attaque->executerAttaque($this, $adversaire);
            } else {
                $_SESSION['messages'][] = $this->nom . " ne peut pas utiliser cette attaque.";
            }
        }

        public function utiliserAttaqueSpeciale(InterfaceCombattant $adversaire): void{
            $this->capaciteSpeciale($adversaire);
        }


        public static function create(array $data): Pokemon{
            switch($data['type']){
                case 'Feu':
                    $instance = new PokemonFeu($data['id'], $data['nom'], $data['pointsDeVie'], $data['puissanceAttaque'], $data['defense'], $data['vitesse']);
                    break;
                case 'Eau':
                    $instance = new PokemonEau($data['id'], $data['nom'], $data['pointsDeVie'], $data['puissanceAttaque'], $data['defense'], $data['vitesse']);
                    break;
                case 'Plante':
                    $instance = new PokemonPlante($data['id'], $data['nom'], $data['pointsDeVie'], $data['puissanceAttaque'], $data['defense'], $data['vitesse']);
                    break;
                default:
                    return null;
            }
            $instance->attaques = (new PokemonModel)->getAttaquesByPokemonID($data['id']);
            return $instance;
        }

        abstract public function capaciteSpeciale(Pokemon $adversaire);
    }

?>

