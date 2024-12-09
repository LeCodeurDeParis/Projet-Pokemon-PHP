-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 08 déc. 2024 à 23:57
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pokemon_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `allattaques`
--

CREATE TABLE `allattaques` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `puissance` int NOT NULL,
  `precision` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `allattaques`
--

INSERT INTO `allattaques` (`id`, `nom`, `type`, `puissance`, `precision`) VALUES
(1, 'Cascade', 'Eau', 80, 100),
(2, 'Coqui-lame', 'Eau', 75, 95),
(3, 'Ébullition', 'Eau', 80, 100),
(4, 'Hydro-Queue', 'Eau', 90, 90),
(6, 'Pistolet à O', 'Eau', 40, 100),
(7, 'Surf', 'Eau', 90, 100),
(8, 'Tranch\'Aqua', 'Eau', 70, 100),
(9, 'Vibraqua', 'Eau', 60, 100),
(10, 'Ballon Brûlant', 'Feu', 120, 90),
(11, 'Calcination', 'Feu', 60, 100),
(12, 'Crocs Feu', 'Feu', 65, 95),
(13, 'Déflagration', 'Feu', 110, 85),
(14, 'Ébullilave', 'Feu', 80, 100),
(15, 'Flammèche', 'Feu', 40, 100),
(16, 'Fouet de Feu', 'Feu', 80, 100),
(18, 'Nitrocharge', 'Feu', 50, 100),
(19, 'Poing Feu', 'Feu', 75, 100),
(20, 'Balle Graine', 'Plante', 75, 100),
(21, 'Canon Graine', 'Plante', 80, 100),
(22, 'Éco-Sphère', 'Plante', 90, 100),
(23, 'Feuille Magik', 'Plante', 60, 100),
(25, 'Lame Feuille', 'Plante', 90, 100),
(26, 'Martobois', 'Plante', 120, 100),
(27, 'Mégafouet', 'Plante', 120, 85),
(28, 'Tranch\'Herbe', 'Plante', 120, 100);

-- --------------------------------------------------------

--
-- Structure de la table `allpokemon`
--

CREATE TABLE `allpokemon` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `pointsDeVie` int NOT NULL,
  `puissanceAttaque` int NOT NULL,
  `defense` int NOT NULL,
  `vitesse` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `allpokemon`
--

INSERT INTO `allpokemon` (`id`, `nom`, `type`, `pointsDeVie`, `puissanceAttaque`, `defense`, `vitesse`) VALUES
(1, 'Dracaufeu', 'Feu', 120, 84, 78, 100),
(2, 'Tortank', 'Eau', 79, 83, 100, 78),
(3, 'Florizarre', 'Plante', 80, 82, 83, 80);

-- --------------------------------------------------------

--
-- Structure de la table `pokemonattaques`
--

CREATE TABLE `pokemonattaques` (
  `pokemon_id` int NOT NULL,
  `attaque_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pokemonattaques`
--

INSERT INTO `pokemonattaques` (`pokemon_id`, `attaque_id`) VALUES
(2, 6),
(2, 7),
(2, 9),
(1, 12),
(1, 13),
(1, 19),
(3, 21),
(3, 23),
(3, 25);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `allattaques`
--
ALTER TABLE `allattaques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `allpokemon`
--
ALTER TABLE `allpokemon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemonattaques`
--
ALTER TABLE `pokemonattaques`
  ADD PRIMARY KEY (`pokemon_id`,`attaque_id`),
  ADD KEY `attaque_id` (`attaque_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `allattaques`
--
ALTER TABLE `allattaques`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `allpokemon`
--
ALTER TABLE `allpokemon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `pokemonattaques`
--
ALTER TABLE `pokemonattaques`
  ADD CONSTRAINT `pokemonattaques_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `allpokemon` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pokemonattaques_ibfk_2` FOREIGN KEY (`attaque_id`) REFERENCES `allattaques` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
