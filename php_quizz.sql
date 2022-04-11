-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 07 avr. 2022 à 14:50
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_quizz`
--

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `que_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la question.',
  `que_intitule` varchar(255) NOT NULL COMMENT 'Intitulé de la question.',
  PRIMARY KEY (`que_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`que_id`, `que_intitule`) VALUES
(23, 'Combien de coupe du monde l\'EDF de football &agrave; t-elle ?'),
(27, 'Dans quel continent se trouve la France ?'),
(29, 'Dans quel pays se trouve Rio de Janeiro ?'),
(30, 'Quel OS n\'existe pas ?');

-- --------------------------------------------------------

--
-- Structure de la table `quizz`
--

DROP TABLE IF EXISTS `quizz`;
CREATE TABLE IF NOT EXISTS `quizz` (
  `qui_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'L''identifiant du quizz.',
  `qui_intitule` varchar(255) NOT NULL COMMENT 'Le nom du quizz.',
  PRIMARY KEY (`qui_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `quizz`
--

INSERT INTO `quizz` (`qui_id`, `qui_intitule`) VALUES
(1, 'quizz 1');

-- --------------------------------------------------------

--
-- Structure de la table `qui_que`
--

DROP TABLE IF EXISTS `qui_que`;
CREATE TABLE IF NOT EXISTS `qui_que` (
  `qui_que_quizz_id` int(11) NOT NULL COMMENT 'L''identifiant du quizz a associé.',
  `qui_que_question_id` int(11) NOT NULL COMMENT 'L''identifiant de la question a associée.',
  KEY `fk_quizz` (`qui_que_quizz_id`),
  KEY `fk_question` (`qui_que_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE IF NOT EXISTS `reponse` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la réponse.',
  `rep_text` varchar(255) NOT NULL COMMENT 'Le texte de la réponse.',
  `rep_istrue` tinyint(1) NOT NULL COMMENT 'Booléen qui permet de savoir si la réponse est vrai ou non.',
  `rep_question_id` int(11) NOT NULL COMMENT 'L''identifiant de la question à laquelle est relié la réponse.',
  PRIMARY KEY (`rep_id`),
  KEY `fk_rep_que` (`rep_question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`rep_id`, `rep_text`, `rep_istrue`, `rep_question_id`) VALUES
(7, '1', 0, 23),
(8, '2', 1, 23),
(9, '3', 0, 23),
(18, 'Asie', 0, 27),
(19, 'Afrique', 0, 27),
(20, 'Europe', 1, 27),
(21, 'Oc&eacute;anie', 0, 27),
(25, 'Pakistan', 0, 29),
(26, 'Grande-Bretagne', 0, 29),
(27, 'Nouvelle-Z&eacute;lande', 0, 29),
(28, 'Br&eacute;sil', 1, 29),
(29, 'Windows', 0, 30),
(30, 'Linux', 0, 30),
(31, 'Ubuntu', 0, 30),
(32, 'PereOk', 1, 30);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `qui_que`
--
ALTER TABLE `qui_que`
  ADD CONSTRAINT `fk_question` FOREIGN KEY (`qui_que_question_id`) REFERENCES `question` (`que_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_quizz` FOREIGN KEY (`qui_que_quizz_id`) REFERENCES `quizz` (`qui_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `fk_rep_que` FOREIGN KEY (`rep_question_id`) REFERENCES `question` (`que_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
