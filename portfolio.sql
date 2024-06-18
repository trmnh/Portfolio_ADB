-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 09 juin 2024 à 16:30
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

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
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `github_link` varchar(255) DEFAULT NULL,
  `live_demo_link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `thumbnail`, `github_link`, `live_demo_link`, `status`) VALUES
(10, 'CERA', '<p class=\"p1\"><span style=\"font-size: 18pt;\"><strong>Projet CERA - Description</strong></span></p>\r\n<p class=\"p1\">&nbsp;</p>\r\n<p class=\"p3\"><span style=\"font-size: 14pt;\"><strong>Nom du projet</strong> :</span> CERA&nbsp;</p>\r\n<p class=\"p2\">&nbsp;</p>\r\n<p class=\"p3\"><span style=\"font-size: 14pt;\"><strong>Description</strong>&nbsp;:</span></p>\r\n<p class=\"p3\">CERA est une application web visant &agrave; am&eacute;liorer l&rsquo;engagement et la communication entre les utilisateurs et les administrateurs d&rsquo;un site web. Elle permet aux utilisateurs de soumettre des requ&ecirc;tes, commentaires et questions via un formulaire de contact r&eacute;actif et intuitif.</p>\r\n<p class=\"p3\">&nbsp;</p>\r\n<p class=\"p1\"><span style=\"font-size: 14pt;\"><strong>Technologies Utilis&eacute;es :</strong></span></p>\r\n<p class=\"p2\">&nbsp;</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>HTML5</strong>&nbsp;: Structure du contenu.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>CSS3</strong>&nbsp;: Stylisation et responsivit&eacute; avec Flexbox et Grid.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>JavaScript</strong>&nbsp;: Fonctionnalit&eacute;s interactives et validation de formulaire en temps r&eacute;el.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>PHP</strong>&nbsp;: Traitement des donn&eacute;es du formulaire c&ocirc;t&eacute; serveur.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>MySQL</strong> : Stockage s&eacute;curis&eacute; des messages utilisateurs.</p>', '6664752ab6f02.png', 'https://github.com/trmnh/', 'https://github.com/trmnh/', 1),
(11, 'Hyperblog PHP', '<p class=\"p1\"><strong>Technologies Utilis&eacute;es :</strong></p>\r\n<p class=\"p2\">&nbsp;</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>HTML5</strong>&nbsp;: Structure du contenu.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>CSS3</strong>&nbsp;: Stylisation et responsivit&eacute; avec Flexbox et Grid.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>JavaScript</strong>&nbsp;: Fonctionnalit&eacute;s interactives et validation de formulaire en temps r&eacute;el.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>PHP</strong>&nbsp;: Traitement des donn&eacute;es du formulaire c&ocirc;t&eacute; serveur.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>MySQL</strong> : Stockage s&eacute;curis&eacute; des messages utilisateurs.</p>', '66646f731d207.png', 'https://github.com/trmnh/', 'https://github.com/trmnh/', 1),
(12, 'Portfolio V1', '<p class=\"p1\"><strong>Technologies Utilis&eacute;es :</strong></p>\r\n<p class=\"p2\">&nbsp;</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>HTML5</strong>&nbsp;: Structure du contenu.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>CSS3</strong>&nbsp;: Stylisation et responsivit&eacute; avec Flexbox et Grid.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>JavaScript</strong>&nbsp;: Fonctionnalit&eacute;s interactives et validation de formulaire en temps r&eacute;el.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>PHP</strong>&nbsp;: Traitement des donn&eacute;es du formulaire c&ocirc;t&eacute; serveur.</p>\r\n<p class=\"p6\">&bull;&nbsp;<strong>MySQL</strong> : Stockage s&eacute;curis&eacute; des messages utilisateurs.</p>', '66646f98cfea9.png', 'https://github.com/trmnh/', 'https://github.com/trmnh/', 1);

-- --------------------------------------------------------

--
-- Structure de la table `project_images`
--

CREATE TABLE `project_images` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `project_images`
--

INSERT INTO `project_images` (`id`, `project_id`, `image_path`) VALUES
(9, 11, '66646f731d84b.png'),
(10, 12, '66646f98d0391.png'),
(11, 10, '666470dfd559b.png'),
(12, 10, '66648489e6b43.png'),
(13, 10, '66659b056a912.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `project_images`
--
ALTER TABLE `project_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `project_images`
--
ALTER TABLE `project_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `project_images`
--
ALTER TABLE `project_images`
  ADD CONSTRAINT `project_images_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
