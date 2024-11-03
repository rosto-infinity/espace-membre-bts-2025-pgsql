-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 26 mai 2024 à 11:34
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `espace_membres2`
--

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mail`, `motdepasse`, `avatar`) VALUES
(1, 'rostogf', 'r@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '1.jpg'),
(2, 'rosto', 'r1@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', ''),
(3, 'waffo', 'w@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '3.jpg'),
(4, 'waffo2', 'w2@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', ''),
(5, 'waffo3', 'w3@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', ''),
(6, 'diane', 'd@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '6.jpg'),
(7, 'rosto5', 'r5@gmail.com', 'e2512172abf8cc9f67fdd49eb6cacf2df71bbad3', '7.jpg'),
(8, 'eva', 'eva@gmail.com', '39dfa55283318d31afe5a3ff4a0e3253e2045e43', '8.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
