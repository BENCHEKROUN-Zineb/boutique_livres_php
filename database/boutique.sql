-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 nov. 2025 à 12:21
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
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id_a` int(11) NOT NULL,
  `nomComplet` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id_a`, `nomComplet`, `img`) VALUES
(12, 'oussama muslim', 'oussamaMusslim.jpg'),
(13, 'hanane lachine', 'hananeLachine.jpeg'),
(14, 'victore hugo', 'victoreHugo.jpg'),
(15, 'auteur 1', 'auteur2.jpeg'),
(16, 'auteur 2', 'auteur2.png');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_c` int(11) NOT NULL,
  `nom_c` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_c`, `nom_c`) VALUES
(11, 'enfant'),
(12, 'aventure'),
(13, 'roman'),
(14, 'nouvelle'),
(15, 'dev personel'),
(16, 'poesie');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `num_cmd` int(11) NOT NULL,
  `date_cmd` date NOT NULL,
  `etat` varchar(30) NOT NULL DEFAULT 'en attente',
  `id_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`num_cmd`, `date_cmd`, `etat`, `id_u`) VALUES
(8, '2024-06-14', 'envoyee', 3),
(9, '2024-06-14', 'envoyee', 3),
(10, '2024-06-14', 'En attente', 3),
(11, '2024-06-29', 'envoyee', 3),
(12, '2024-07-16', 'envoyee', 3),
(13, '2025-03-26', 'annulee', 3),
(14, '2025-10-04', 'en cours de traitement', 3),
(15, '2025-11-29', 'En attente', 3);

-- --------------------------------------------------------

--
-- Structure de la table `detailcmd`
--

CREATE TABLE `detailcmd` (
  `num_cmd` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `detailcmd`
--

INSERT INTO `detailcmd` (`num_cmd`, `id_prod`, `qte`) VALUES
(8, 34, 2),
(9, 36, 1),
(9, 37, 1),
(9, 39, 1),
(10, 37, 2),
(10, 42, 1),
(11, 36, 1),
(11, 42, 1),
(12, 37, 1),
(13, 37, 1),
(13, 38, 1),
(14, 37, 1),
(15, 37, 1),
(15, 38, 2);

-- --------------------------------------------------------

--
-- Structure de la table `detailpanier`
--

CREATE TABLE `detailpanier` (
  `id_pa` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_pa` int(11) NOT NULL,
  `id_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_pa`, `id_u`) VALUES
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_prod` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `nbpage` int(11) NOT NULL,
  `langue` varchar(255) NOT NULL,
  `editionn` varchar(255) NOT NULL,
  `datepublication` year(4) NOT NULL,
  `descriptionn` varchar(500) DEFAULT NULL,
  `note` int(11) NOT NULL,
  `prix` float NOT NULL,
  `remise` int(11) DEFAULT NULL,
  `qteS` int(11) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `id_a` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_prod`, `titre`, `nbpage`, `langue`, `editionn`, `datepublication`, `descriptionn`, `note`, `prix`, `remise`, `qteS`, `img`, `id_a`) VALUES
(34, 'khawf 1', 250, 'arabe', 'edition', '2014', ' khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1khwf 1', 5, 200, 25, 10, '666c0d7c39b47.png', 12),
(35, 'khawf 2', 300, 'arabe', 'edition', '2015', 'khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 ', 5, 200, 75, 50, '666c0daa1cfc8.png', 12),
(36, 'khawf 3', 300, 'arabe', 'edition', '2014', 'khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 khwf 2 ', 5, 200, 25, 50, '666c0de77cb2c.png', 12),
(37, 'ikadoli', 250, 'arabe', 'edition', '2016', 'description description description description description description description description description description description ', 5, 50, 25, 50, '666c0e1170d44.png', 13),
(38, 'opal', 300, 'arabe', 'edition', '2019', 'description description description description description description description description description description description ', 5, 200, 25, 50, '666c0e32de555.png', 13),
(39, 'amanous', 250, 'arabe', 'edition', '2014', 'description description description description description description description description description description description description ', 5, 150, 25, 10, '666c0e5570dbe.png', 13),
(40, 'les miserables', 400, 'francais', 'edition', '0000', 'description description description description description description description description description description description description ', 5, 150, 25, 50, '666c0eb4c8d6c.png', 14),
(41, 'travailleurs de la mer', 400, 'francais', 'edition', '0000', 'description description description description description description description description description description description description ', 5, 150, 75, 50, '666c0ef91023d.png', 14),
(42, 'caillou', 23, 'francais', 'edition', '1999', 'description description description description description description description description description description description description description ', 5, 50, 75, 50, '666c0f33d3c99.png', 15),
(43, 'dernier jour', 150, 'francais', 'edition', '2000', 'description description description description description description ', 5, 150, 75, 10, '666c0f751e9cc.png', 14),
(44, 'avoir confiance en soi', 250, 'francais', 'edition', '2000', 'description description description description description description description description description description description ', 5, 200, 25, 10, '666c0fd107cd3.png', 16),
(45, 'une annee une poesie', 365, 'francais', 'edition', '2017', 'description description description description description description ', 5, 150, 75, 5, '666c1235b471d.png', 16),
(46, 'developpement personnel chang(c)e', 222, 'francais', 'edition', '1999', 'description description description description description description ', 5, 200, 25, 10, '666c126dc6966.png', 12),
(47, 'notre dame de paris', 300, 'arabe', 'edition', '2000', 'description description description description description description description ', 5, 200, 25, 10, '666c1299ab29b.png', 14),
(48, 'ile au tresor', 250, 'francais', 'edition', '2002', 'description description description description description description description description description description description ', 5, 50, 25, 10, '666c13902ee80.png', 16);

-- --------------------------------------------------------

--
-- Structure de la table `prod_categ`
--

CREATE TABLE `prod_categ` (
  `id_prod` int(11) NOT NULL,
  `id_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `prod_categ`
--

INSERT INTO `prod_categ` (`id_prod`, `id_c`) VALUES
(34, 12),
(35, 12),
(36, 12),
(37, 13),
(38, 13),
(39, 13),
(40, 13),
(41, 13),
(42, 11),
(43, 13),
(44, 15),
(45, 16),
(46, 15),
(47, 14),
(48, 11);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_u` int(11) NOT NULL,
  `nom_u` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `genre` varchar(30) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_u`, `nom_u`, `email`, `mdp`, `genre`, `isadmin`, `img`) VALUES
(3, 'zineb', 'zineb@gmail.com', '123456', 'femme', 0, NULL),
(4, 'zohra', 'zohra@gmail.com', '123456', 'femme', 1, NULL),
(5, 'hassan', 'hassan@gmail.com', '$2y$10$.XtJaqN1nx7O7oln2nNxne19lMCrgr502atHYqhWWehx1XyOrsxM.', 'homme', 0, NULL),
(6, 'rajae', 'rajae@gmail.com', '$2y$10$MKa3CcGjgB9k5m0qy8BOn.3U2kU/pjh6OmiXfU6OBTCNcI4xokR9y', 'femme', 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id_a`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_c`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`num_cmd`),
  ADD KEY `fk_cmd` (`id_u`);

--
-- Index pour la table `detailcmd`
--
ALTER TABLE `detailcmd`
  ADD PRIMARY KEY (`num_cmd`,`id_prod`),
  ADD KEY `fk_detailCmdd` (`id_prod`);

--
-- Index pour la table `detailpanier`
--
ALTER TABLE `detailpanier`
  ADD PRIMARY KEY (`id_pa`,`id_prod`),
  ADD KEY `fk_detailPaa` (`id_prod`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_pa`),
  ADD KEY `fk_panier` (`id_u`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `fk_auteur` (`id_a`);

--
-- Index pour la table `prod_categ`
--
ALTER TABLE `prod_categ`
  ADD PRIMARY KEY (`id_prod`,`id_c`),
  ADD KEY `fk_prodd_categg` (`id_c`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_u`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_c` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `num_cmd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_pa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_cmd` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `detailcmd`
--
ALTER TABLE `detailcmd`
  ADD CONSTRAINT `fk_detailCmd` FOREIGN KEY (`num_cmd`) REFERENCES `commande` (`num_cmd`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detailCmdd` FOREIGN KEY (`id_prod`) REFERENCES `produit` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `detailpanier`
--
ALTER TABLE `detailpanier`
  ADD CONSTRAINT `fk_detailPa` FOREIGN KEY (`id_pa`) REFERENCES `panier` (`id_pa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detailPaa` FOREIGN KEY (`id_prod`) REFERENCES `produit` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_panier` FOREIGN KEY (`id_u`) REFERENCES `utilisateur` (`id_u`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_auteur` FOREIGN KEY (`id_a`) REFERENCES `auteur` (`id_a`);

--
-- Contraintes pour la table `prod_categ`
--
ALTER TABLE `prod_categ`
  ADD CONSTRAINT `fk_prod_categ` FOREIGN KEY (`id_prod`) REFERENCES `produit` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodd_categg` FOREIGN KEY (`id_c`) REFERENCES `categorie` (`id_c`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
