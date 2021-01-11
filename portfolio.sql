-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 29 déc. 2020 à 02:34
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `accueil`
--

CREATE TABLE `accueil` (
  `id_accueil` int(5) NOT NULL,
  `image_id` int(5) DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `paragraphe1` varchar(255) NOT NULL,
  `paragraphe2` varchar(255) NOT NULL,
  `bouton` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `accueil`
--

INSERT INTO `accueil` (`id_accueil`, `image_id`, `titre`, `paragraphe1`, `paragraphe2`, `bouton`) VALUES
(1, 25, 'Développeur Web Full Stack', 'UX design, Réferencement, Tous types de site', '', 'En savoir davantage'),
(2, 47, 'Formateur du développement web', 'HTML CSS SQL PHP SYMFONY WORDPRESS', '', 'En savoir plus'),
(3, 46, 'Services proposés', 'Conception intégrale d\'un site web', 'Résultat 100% satisfait', 'En savoir plus');

-- --------------------------------------------------------

--
-- Structure de la table `coordonnee`
--

CREATE TABLE `coordonnee` (
  `id_coordonnee` int(5) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `coordonnee`
--

INSERT INTO `coordonnee` (`id_coordonnee`, `titre`, `nom`) VALUES
(1, 'téléphone', '07.50.24.48.60'),
(2, 'email', 'bldlr170289@gmail.com'),
(3, 'département', 'Yvelines'),
(4, 'région', 'Ile-de-France'),
(5, 'email contact', 'bldlr170289@gmail.com'),
(6, 'Me', 'Contacter');

-- --------------------------------------------------------

--
-- Structure de la table `developpeur`
--

CREATE TABLE `developpeur` (
  `id_developpeur` int(3) NOT NULL,
  `titre1` varchar(255) NOT NULL,
  `titre2` varchar(255) NOT NULL,
  `titre_specialisation` varchar(255) NOT NULL,
  `xp` int(4) NOT NULL,
  `titre_txt1` varchar(255) NOT NULL,
  `titre_txt2` varchar(255) NOT NULL,
  `texte1` longtext NOT NULL,
  `texte2` longtext NOT NULL,
  `texte3` longtext NOT NULL,
  `image_id` int(3) DEFAULT NULL,
  `image_xp_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `developpeur`
--

INSERT INTO `developpeur` (`id_developpeur`, `titre1`, `titre2`, `titre_specialisation`, `xp`, `titre_txt1`, `titre_txt2`, `texte1`, `texte2`, `texte3`, `image_id`, `image_xp_id`) VALUES
(1, 'Développeur Web', 'Full Stack', 'Spécialisations', 2016, 'à', 'savoir', 'Au XXIe siècle, Internet est devenu le réseau de communication prédominant de la planète. Il est utilisé dans tous les domaines : communication, connaissance, recherche, stockage, achat, vente soit transaction financière', 'Pour une recherche, notre réflexe est de consulter un moteur de recherche.', 'il est donc primordial d’être présent mais surtout visible sur la toile. Pour cela, il faut combiner l\'ergonomie, le responsive(différents formats visuels), le référencement afin que le site soit en tête de classement dans les moteurs de recherche.', 32, 38);

-- --------------------------------------------------------

--
-- Structure de la table `formateur`
--

CREATE TABLE `formateur` (
  `id_formateur` int(3) NOT NULL,
  `titre1` varchar(255) NOT NULL,
  `titre2` varchar(255) NOT NULL,
  `image_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formateur`
--

INSERT INTO `formateur` (`id_formateur`, `titre1`, `titre2`, `image_id`) VALUES
(1, 'Formateur', 'Web', 64),
(2, 'Langages', '', NULL),
(3, 'Frameworks', '', NULL),
(4, 'CMS', '', NULL),
(5, 'Logiciels', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int(5) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `statut` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `titre`, `statut`) VALUES
(25, 'low-poly-3636376_1920.jpg', 1),
(26, 'color-2174065_1280.png', 2),
(28, 'triangles-3784908_1920.png', 1),
(29, 'triangles-3320452_1280.png', 3),
(30, 'fiesta-1503400_1280.png', 3),
(32, '20201225_130127.jpg', 4),
(33, 'bart.png', 4),
(38, 'text-1.jpg', 5),
(41, 'green-1072828_1920.jpg', 5),
(42, 'gold-163519_640.jpg', 5),
(44, 'sky-1675275_1920.jpg', 2),
(45, 'purple-1862798_1920.jpg', 3),
(46, 'lionne.png', 3),
(47, 'michael-dziedzic-uZr0oWxrHYs-unsplash.jpg', 2),
(48, 'fireworks-574739_640.jpg', 5),
(50, 'themexp.png', 5),
(51, 'gold-2889423_640.jpg', 5),
(52, 'alcohol-2178775_640.jpg', 5),
(53, 'gold-2889423_640.jpg', 3),
(60, '20201228112231icon-drawing.png', 6),
(61, '20201228115211icon-house-plans.png', 7),
(62, '20201228115347icon-house-key.png', 8),
(64, '20201228175842formateur.jpg', 9);

-- --------------------------------------------------------

--
-- Structure de la table `langages`
--

CREATE TABLE `langages` (
  `id_langage` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `statut` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `langages`
--

INSERT INTO `langages` (`id_langage`, `titre`, `image`, `statut`) VALUES
(1, 'HTML', '20201228214632html.png', 1),
(3, 'CSS', '20201228213356css.png', 1),
(4, 'WORDPRESS', '20201228230044wordpress.png', 3),
(5, 'Photoshop', '20201228230815photoshop.png', 4),
(7, 'Illustrator', '20201228232749illustrator.png', 4),
(10, 'BOOTSTRAP', '20201228235000bootstrap.png', 2),
(11, 'Symfony', '20201228235121Symfony.png', 2),
(13, 'SQL', '20201229012129sql.png', 1),
(14, 'PHP - POO', '20201229012145php.png', 1);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(5) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `statut` int(1) NOT NULL,
  `token` int(5) NOT NULL,
  `action` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `email`, `mdp`, `statut`, `token`, `action`) VALUES
(1, 'bldlr170289@gmail.com', '$2y$10$.lTcJKXuYsuv.dfsY12yP.m3uHWCQ00N8CyqjotDlbZnOiQY/TeIq', 2, 69696, 1),
(10, 'intellagence2020@gmail.com', '$2y$10$z6/BM9bwZGa9DIoBbIhz3.DgIvN5MLOJmRFf9Hb0nyqgvY9K2a67q', 1, 75829, 1);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id_service` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `paragraphe1` varchar(255) NOT NULL,
  `paragraphe2` varchar(255) NOT NULL,
  `paragraphe3` varchar(255) NOT NULL,
  `image_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_service`, `titre`, `paragraphe1`, `paragraphe2`, `paragraphe3`, `image_id`) VALUES
(1, 'OBSERVATION', 'Conception du cahier des charges', 'Proposition de devis', 'Constitution de la maquette', 60),
(2, 'RÉALISATION', 'Développement du design', 'Responsive : tous types de formats', 'Création des algorythmes', 61),
(3, 'HÉBERGEMENT', 'Élaboration du référencement', 'Installation des services Google', 'Site en ligne', 62),
(4, '', 'SERVICES', 'PROPOSÉS', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `specialisations`
--

CREATE TABLE `specialisations` (
  `id_specialisation` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `specialisations`
--

INSERT INTO `specialisations` (`id_specialisation`, `titre`, `image`) VALUES
(1, 'BACK OFFICE', '20201229020615icon-architecture.png'),
(2, 'ECOMMERCE', '20201229020626icon-interiors.png'),
(4, 'CHALLENGE', '20201229020656icon-planing.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accueil`
--
ALTER TABLE `accueil`
  ADD PRIMARY KEY (`id_accueil`),
  ADD KEY `accueil_ibfk_1` (`image_id`);

--
-- Index pour la table `coordonnee`
--
ALTER TABLE `coordonnee`
  ADD PRIMARY KEY (`id_coordonnee`);

--
-- Index pour la table `developpeur`
--
ALTER TABLE `developpeur`
  ADD PRIMARY KEY (`id_developpeur`),
  ADD KEY `image_id` (`image_id`),
  ADD KEY `image_xp_id` (`image_xp_id`);

--
-- Index pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD PRIMARY KEY (`id_formateur`),
  ADD KEY `image_id` (`image_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`);

--
-- Index pour la table `langages`
--
ALTER TABLE `langages`
  ADD PRIMARY KEY (`id_langage`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`),
  ADD KEY `services_ibfk_1` (`image_id`);

--
-- Index pour la table `specialisations`
--
ALTER TABLE `specialisations`
  ADD PRIMARY KEY (`id_specialisation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accueil`
--
ALTER TABLE `accueil`
  MODIFY `id_accueil` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `coordonnee`
--
ALTER TABLE `coordonnee`
  MODIFY `id_coordonnee` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `developpeur`
--
ALTER TABLE `developpeur`
  MODIFY `id_developpeur` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formateur`
--
ALTER TABLE `formateur`
  MODIFY `id_formateur` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT pour la table `langages`
--
ALTER TABLE `langages`
  MODIFY `id_langage` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `specialisations`
--
ALTER TABLE `specialisations`
  MODIFY `id_specialisation` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accueil`
--
ALTER TABLE `accueil`
  ADD CONSTRAINT `accueil_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id_image`) ON DELETE SET NULL;

--
-- Contraintes pour la table `developpeur`
--
ALTER TABLE `developpeur`
  ADD CONSTRAINT `developpeur_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id_image`) ON DELETE SET NULL,
  ADD CONSTRAINT `developpeur_ibfk_2` FOREIGN KEY (`image_xp_id`) REFERENCES `images` (`id_image`) ON DELETE SET NULL;

--
-- Contraintes pour la table `formateur`
--
ALTER TABLE `formateur`
  ADD CONSTRAINT `formateur_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id_image`) ON DELETE SET NULL;

--
-- Contraintes pour la table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id_image`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
