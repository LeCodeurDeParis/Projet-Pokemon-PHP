<?php
    class CombatController{
        // Déclaration des propriétés
        public PokemonModel $pokemonModel;
        public AttaqueModel $attaqueModel;
        public Pokemon $pokemon1;
        public Pokemon $pokemon2;
        public bool $soinUtilise = false;

        // Constructeur de la classe
        public function __construct() {
            $this->pokemonModel = new PokemonModel();
            $this->attaqueModel = new AttaqueModel();
        }

        // Méthode pour démarrer le combat
        public function demarrerCombat() {
            // Vérifie si la requête est POST et si un Pokémon a été choisi
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon_id'])) {
                $pokemonId = (int) $_POST['pokemon_id'];
    
                // Récupérer le Pokémon choisi par l'utilisateur
                $this->pokemon1 = Pokemon::create($this->pokemonModel->findOneById($pokemonId));
    
                // Initialiser les Pokémon pour le combat
                $this->pokemon2 = Pokemon::create($this->pokemonModel->findRandomWithoutId($pokemonId));
                // Mettre à jour la session
                $this->updateSession();
            } else {
                // Si aucun Pokémon n'a été choisi, afficher un message d'erreur
                die('Aucun Pokémon choisi.');
            }
            // Afficher la vue principale du combat
            $this->index();
        }

        // Méthode pour attaquer
        public function attaquer(){
            // Récupérer les données de la session
            $this->getSession();
            // Récupérer l'attaque choisie par l'utilisateur
            $attaque = $this->attaqueModel->findOneByIdLinkedToPokemon($_POST['attaque'], $this->pokemon1->id);
             // L'attaquant choisit son attaque
            if (isset($attaque)) {
                $this->pokemon1->seBattre($this->pokemon2, $attaque);
                // Déterminer le vainqueur
                if(!$this->determinerVainqueur()){
                    // Si aucun vainqueur, c'est au tour de l'adversaire
                    $this->tourDeAdversaire();
                    $this->determinerVainqueur();
                }
            }
            // Mettre à jour la session
            $this->updateSession();
            $this->index();
        }

        public function seSoigner(){
            // Récupérer les données de la session
            $this->getSession();
            // Vérifier si le soin a déjà été utilisé
            if (!$this->soinUtilise) {
                // Soigner le Pokémon
                $this->pokemon1->soigner();
                $_SESSION['messages'][] = $this->pokemon1->nom . " est soigné et a maintenant " . $this->pokemon1->pointsDeVie . " points de vie.";
                $this->soinUtilise = true;
            } else {
                // Ajouter un message indiquant que le soin a déjà été utilisé
                $_SESSION['messages'][] = "Le soin a déjà été utilisé.";
            }
            $this->updateSession();
            $this->index();
        }

        // Méthode pour utiliser une capacité spéciale
        public function capaSpeVs(): void{
            $this->getSession();
            // Utiliser l'attaque spéciale
            $this->pokemon1->utiliserAttaqueSpeciale($this->pokemon2);
            if(!$this->determinerVainqueur()){
                // Si aucun vainqueur, c'est au tour de l'adversaire
                $this->tourDeAdversaire();
                $this->determinerVainqueur();
            }
            $this->updateSession();
            $this->index();
        }

        // Méthode pour gérer le tour de l'adversaire
        protected function tourDeAdversaire(){
            // Récupérer les attaques de l'adversaire
            $attaques = $this->pokemonModel->getAttaquesByPokemonID($this->pokemon2->id);
            // L'adversaire choisit une attaque aléatoire
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

        // Méthode pour recommencer le combat
        public function recommencer() {
            // Détruire la session
            session_destroy();
            // Rediriger vers la page de choix des Pokémon
            header('Location: /Pokemon/choose');
            exit();
        }

        // Méthode pour afficher la vue principale du combat
        protected function index($vainqueur = null){
            $pokemon1 = $this->pokemon1;
            $pokemon2 = $this->pokemon2;
            $messages = $_SESSION['messages'] ?? [];
            require_once __DIR__ . '/../views/test.php';
        }

        // Méthode pour mettre à jour la session
        protected function updateSession() {
            $_SESSION['combat'] = serialize(array('pokemon1' => $this->pokemon1, 'pokemon2'=> $this->pokemon2, 'soinUtilise' => $this->soinUtilise));
        }

        // Méthode pour récupérer les données de la session
        protected function getSession() {
            $data = unserialize($_SESSION['combat']);
            $this->pokemon1 = $data['pokemon1'];
            $this->pokemon2 = $data['pokemon2'];
            $this->soinUtilise = $data['soinUtilise'];
        }
    }
        
?>