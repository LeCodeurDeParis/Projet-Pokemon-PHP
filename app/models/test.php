<?php
// Inclure les fichiers nécessaires
require_once 'Pokemon.php';
require_once 'PokemonEau.php';
require_once 'Attaque.php';
require_once '../controllers/Combat.php';
require_once 'InterfacesCombattants.php';

// Création de Pokémon et d'attaques
$pokemon1 = new PokemonEau("Carapuce", 100, 20, 10, 15);
$pokemon2 = new PokemonEau("Bulbizarre", 100, 18, 12, 13);

// Création d'attaques
$attaque1 = new Attaque("Pistolet à O", 30, 90);  // Nom, puissance, précision
$attaque2 = new Attaque("Jet d'Eau", 25, 85);

// Ajout des attaques aux Pokémon
$pokemon1->ajouterAttaque($attaque1);
$pokemon2->ajouterAttaque($attaque2);

// Création d'un combat
$combat = new Combat($pokemon1, $pokemon2);

// Démarrer le combat
echo "<h2>Début du combat entre " . $pokemon1->nom . " et " . $pokemon2->nom . "</h2>";
$combat->seBattre();
?>
