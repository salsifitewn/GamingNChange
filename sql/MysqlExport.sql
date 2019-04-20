-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mer 17 Avril 2019 à 18:16
-- Version du serveur :  10.1.37-MariaDB-0+deb9u1
-- Version de PHP :  7.3.3-1+0~20190307202245.32+stretch~1.gbp32ebb2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gamenchange.fr`
--

-- --------------------------------------------------------

--
-- Structure de la table `Games`
--

CREATE TABLE `Games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_release_year` date NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `developper_id` int(11) NOT NULL,
  `summary` text,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `franchise` int(11) DEFAULT NULL,
  `dlc_game` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Games_Companies`
--

CREATE TABLE `Games_Companies` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `publisher` tinyint(1) NOT NULL,
  `developper` tinyint(1) NOT NULL,
  `vendor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Platforms`
--

CREATE TABLE `Platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_logo` varchar(255) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Platform_Released_Games`
--

CREATE TABLE `Platform_Released_Games` (
  `id` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `id_platform` int(11) NOT NULL,
  `released_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Games`
--
ALTER TABLE `Games`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Games_Companies`
--
ALTER TABLE `Games_Companies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Platforms`
--
ALTER TABLE `Platforms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Platform_Released_Games`
--
ALTER TABLE `Platform_Released_Games`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Games`
--
ALTER TABLE `Games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
