<?php

    // Déclaration de la classe abstraite Pokemon qui implémente l'interface InterfaceCombattant
    abstract class Pokemon implements InterfaceCombattant{
        // Déclaration des propriétés
        public int $id;
        public string $nom;
        public string $type;
        public int $pointsDeVie;
        public int $pointsDeVieMax;
        public int $puissanceAttaque;
        public int $defense;
        public int $vitesse;
        public array $attaques = [];

        // Utilisation du trait Soins
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

        // Méthode pour recevoir des dégâts
        public function recevoirDegats($degats){
            $this->pointsDeVie -= (int) $degats;
            if ($this->pointsDeVie < 0) {
                $this->pointsDeVie = 0;
            }
            $_SESSION['messages'][] = $this->nom . " reçoit " . $degats . " points de dégâts. " . $this->nom . " a maintenant " . $this->pointsDeVie . " points de vie.";
        }

        // Méthode pour vérifier si le Pokémon est KO
        public function estKO(){
            if($this->pointsDeVie <= 0){
                return true;
            }else{
                return false;
            }
        }

        // Méthode pour se battre contre un adversaire
        public function seBattre(InterfaceCombattant $adversaire, Attaque $attaque): void{
            // Vérifier si l'attaque est liée au Pokémon
            if ((new AttaqueModel)->isLinkedToPokemon($attaque->getID(), $this->id)) {
                $attaque->executerAttaque($this, $adversaire);
            } else {
                $_SESSION['messages'][] = $this->nom . " ne peut pas utiliser cette attaque.";
            }
        }

        // Méthode pour utiliser une attaque spéciale
        public function utiliserAttaqueSpeciale(InterfaceCombattant $adversaire): void{
            $this->capaciteSpeciale($adversaire);
        }

        // Méthode statique pour créer une instance de Pokémon en fonction de son type
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
            // Récupérer les attaques du Pokémon
            $instance->attaques = (new PokemonModel)->getAttaquesByPokemonID($data['id']);
            return $instance;
        }

        // Méthode abstraite pour la capacité spéciale du Pokémon
        abstract public function capaciteSpeciale(Pokemon $adversaire);
    }

?>

