<?php
    class CombatController{
        public PokemonModel $pokemonModel;
        public AttaqueModel $attaqueModel;
        public Pokemon $pokemon1;
        public Pokemon $pokemon2;
        public bool $soinUtilise = false;

        public function __construct() {
            $this->pokemonModel = new PokemonModel();
            $this->attaqueModel = new AttaqueModel();
        }

        public function demarrerCombat() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon_id'])) {
                $pokemonId = (int) $_POST['pokemon_id'];
    
                // Récupérer le Pokémon choisi par l'utilisateur
                $this->pokemon1 = Pokemon::create($this->pokemonModel->findOneById($pokemonId));
    
                // Initialiser les Pokémon pour le combat
                $this->pokemon2 = Pokemon::create($this->pokemonModel->findRandomWithoutId($pokemonId));
    
                $this->updateSession();
            } else {
                die('Aucun Pokémon choisi.');
            }
            $this->index();
        }

        public function attaquer(){
            $this->getSession();
            $attaque = $this->attaqueModel->findOneByIdLinkedToPokemon($_POST['attaque'], $this->pokemon1->id);
             // L'attaquant choisit son attaque
            if (isset($attaque)) {
                $this->pokemon1->seBattre($this->pokemon2, $attaque);
                if(!$this->determinerVainqueur()){
                    $this->tourDeAdversaire();
                    $this->determinerVainqueur();
                }
            }
            $this->updateSession();
            $this->index();
        }

        public function seSoigner(){
            $this->getSession();
            if (!$this->soinUtilise) {
                $this->pokemon1->soigner();
                $_SESSION['messages'][] = $this->pokemon1->nom . " est soigné et a maintenant " . $this->pokemon1->pointsDeVie . " points de vie.";
                $this->soinUtilise = true;
            } else {
                $_SESSION['messages'][] = "Le soin a déjà été utilisé.";
            }
            $this->updateSession();
            $this->index();
        }

        public function capaSpeVs(): void{
            $this->getSession();
            $this->pokemon1->utiliserAttaqueSpeciale($this->pokemon2);
            if(!$this->determinerVainqueur()){
                $this->tourDeAdversaire();
                $this->determinerVainqueur();
            }
            $this->updateSession();
            $this->index();
        }

        protected function tourDeAdversaire(){
            $attaques = $this->pokemonModel->getAttaquesByPokemonID($this->pokemon2->id);
            $this->pokemon2->seBattre($this->pokemon1, $attaques[array_rand($attaques)]);
        }

        protected function determinerVainqueur() {
            // Vérifie si l'un des Pokémon est KO et détermine le vainqueur
            if ($this->pokemon2->estKO() || $this->pokemon1->estKO()) {            
                if ($this->pokemon1->estKO()) {
                    $_SESSION['messages'][] = $this->pokemon2->nom . " a gagné !";
                    
                } else {
                    $_SESSION['messages'][] = $this->pokemon1->nom . " a gagné !";
                    
                }
                return true;
            }
            return false;
        }

        public function recommencer() {
            session_destroy();
            header('Location: /Pokemon/choose');
            exit();
        }

        protected function index($vainqueur = null){
            $pokemon1 = $this->pokemon1;
            $pokemon2 = $this->pokemon2;
            $messages = $_SESSION['messages'] ?? [];
            require_once __DIR__ . '/../views/test.php';
        }

        protected function updateSession() {
            $_SESSION['combat'] = serialize(array('pokemon1' => $this->pokemon1, 'pokemon2'=> $this->pokemon2, 'soinUtilise' => $this->soinUtilise));
        }

        protected function getSession() {
            $data = unserialize($_SESSION['combat']);
            $this->pokemon1 = $data['pokemon1'];
            $this->pokemon2 = $data['pokemon2'];
            $this->soinUtilise = $data['soinUtilise'];
        }
    }
        
    //     $combatController = new CombatController();
    //     $vainqueur = null;

    //     // Si un choix d'attaque est soumis
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $_SESSION['messages'] = [];

    //         $choixAttaque = isset($_POST['attaque']) ? filter_var($_POST['attaque'], FILTER_VALIDATE_INT) : null;
    //         $soin = isset($_POST['soin']);

    //         if ($choixAttaque === false || $choixAttaque < 0 || $choixAttaque >= count($combatController->pokemon1->attaques)) {
    //             die('Attaque invalide.');
    //         }

    //         // Exécute le combat
    //         $vainqueur = $combatController->seBattre($choixAttaque, $soin);
    //     }

    // $combatController->index($vainqueur);
?>