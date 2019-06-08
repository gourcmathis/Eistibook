-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2019 at 12:14 PM
-- Server version: 5.5.60
-- PHP Version: 5.4.45-0+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2018_p0_cpi02_protonguil`
--

-- --------------------------------------------------------

--
-- Table structure for table `AMIS`
--

CREATE TABLE IF NOT EXISTS `AMIS` (
  `ID_UTILISATEURS` int(11) NOT NULL,
  `ID_AMIS` int(11) NOT NULL,
  `BLOQUE` int(1) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`,`ID_AMIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AMIS`
--

INSERT INTO `AMIS` (`ID_UTILISATEURS`, `ID_AMIS`, `BLOQUE`) VALUES
(56, 60, 0),
(58, 52, 0),
(58, 56, 0),
(60, 61, 0),
(62, 63, 0),
(63, 62, 0);

-- --------------------------------------------------------

--
-- Table structure for table `CARACTERE`
--

CREATE TABLE IF NOT EXISTS `CARACTERE` (
  `ID_CARACTERE` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(300) NOT NULL,
  PRIMARY KEY (`ID_CARACTERE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `CARACTERE`
--

INSERT INTO `CARACTERE` (`ID_CARACTERE`, `NOM`) VALUES
(1, 'modeste'),
(2, 'arrogant'),
(3, 'impulsif'),
(4, 'joyeux'),
(5, 'reflechi'),
(6, 'ponctuel'),
(7, 'timide'),
(8, 'extraverti');

-- --------------------------------------------------------

--
-- Table structure for table `COMPETENCES`
--

CREATE TABLE IF NOT EXISTS `COMPETENCES` (
  `ID_COMPETENCES` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(300) NOT NULL,
  PRIMARY KEY (`ID_COMPETENCES`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `COMPETENCES`
--

INSERT INTO `COMPETENCES` (`ID_COMPETENCES`, `NOM`) VALUES
(1, 'organisation'),
(2, 'adaptation'),
(3, 'autonomie'),
(4, 'fiabilite');

-- --------------------------------------------------------

--
-- Table structure for table `EISTI_BOOK_UTILISATEUR`
--

CREATE TABLE IF NOT EXISTS `EISTI_BOOK_UTILISATEUR` (
  `TYPE` varchar(30) NOT NULL DEFAULT 'utilisateur',
  `NOM` varchar(50) NOT NULL,
  `PRENOM` varchar(30) NOT NULL,
  `LOGIN` varchar(50) NOT NULL,
  `PROFESSION` varchar(50) NOT NULL,
  `VILLE` varchar(40) NOT NULL,
  `INTRO` varchar(300) NOT NULL,
  `CITATION` varchar(30) NOT NULL,
  `LOISIR` varchar(300) NOT NULL,
  `SEXE` varchar(20) NOT NULL,
  `PHOTO` varchar(80) NOT NULL,
  `EMPLOIS` varchar(300) NOT NULL,
  `DIPLOME` varchar(300) NOT NULL,
  `MDP` varchar(40) NOT NULL,
  `ID_UTILISATEURS` int(11) NOT NULL AUTO_INCREMENT,
  `SIGNALEMENT` varchar(400) NOT NULL,
  `BAN` tinyint(1) NOT NULL,
  `MUR` varchar(255) NOT NULL,
  `NAISSANCE` varchar(50) NOT NULL,
  `PROMOTION` int(100) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `EISTI_BOOK_UTILISATEUR`
--

INSERT INTO `EISTI_BOOK_UTILISATEUR` (`TYPE`, `NOM`, `PRENOM`, `LOGIN`, `PROFESSION`, `VILLE`, `INTRO`, `CITATION`, `LOISIR`, `SEXE`, `PHOTO`, `EMPLOIS`, `DIPLOME`, `MDP`, `ID_UTILISATEURS`, `SIGNALEMENT`, `BAN`, `MUR`, `NAISSANCE`, `PROMOTION`) VALUES
('utilisateur', 'Sarkozy', 'Nicolas', 'nico@eisti.eu', '', '', '', '', '', '', '', '', '', '202cb962ac59075b964b07152d234b70', 56, '', 0, '', '2000-01-01', 2022),
('admin', 'BERNEDO', 'Hugo', 'bernedohug@eisti.eu', 'Etudiant', 'Bordeaux', 'EISTI ENGINEERING SCHOOL\r\nPRIVATE DRIVER\r\nA la rec', 'SI VIS PACEM PARA BELLUM ', 'Sports bateaux ski nautique montres', 'on', 'image/2019-06-07 15:21:44/bonjour.jpg', 'Etudier', 'Brevet', 'aa36dc6e81e2ac7ad03e12fedcb6a2c0', 58, '', 0, '', '1998-02-07', 2022),
('utilisateur', 'Gourc', 'Mathis', 'gourcmathi@eisti.eu', 'Carreleur', 'JuranÃ§on', 'Ceci est ma lonnnnnnnnnnnnnnnnnnnnnngue introduction', 'Ceci est ma citation', 'Tennis, lecture', 'on', 'image/2019-06-07 15:31:14/bonjour.jpg', '', 'Bac S', '202cb962ac59075b964b07152d234b70', 60, '', 0, '', '1999-12-17', 2022),
('utilisateur', 'tempo', 'thomas', 'thoto@eisti.eu', '', '', '', '', '', 'on', '', '', '', 'aa36dc6e81e2ac7ad03e12fedcb6a2c0', 61, '', 0, '', '1253-12-12', 666),
('utilisateur', 'Salut', 'Fred', 'fred@mail.com', '', '', '', '', '', '', '', '', '', '202cb962ac59075b964b07152d234b70', 62, '', 0, '', '1984-06-11', 2000),
('utilisateur', 'test', 'test', 't@t.fr', '', '', '', '', '', '', '', '', '', '202cb962ac59075b964b07152d234b70', 63, '', 0, '', '2019-06-04', 2000),
('utilisateur', 'a', 'a', 'a@gmail.com', '', '', '', '', '', '', '', '', '', '202cb962ac59075b964b07152d234b70', 64, '', 0, '', '2019-06-03', 2333);

-- --------------------------------------------------------

--
-- Table structure for table `LANGUE`
--

CREATE TABLE IF NOT EXISTS `LANGUE` (
  `ID_LANGUE` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(300) NOT NULL,
  PRIMARY KEY (`ID_LANGUE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `LANGUE`
--

INSERT INTO `LANGUE` (`ID_LANGUE`, `NOM`) VALUES
(1, 'francais'),
(2, 'anglais'),
(3, 'espagnol'),
(4, 'russe'),
(5, 'chinois');

-- --------------------------------------------------------

--
-- Table structure for table `MATCH_CARACTERE`
--

CREATE TABLE IF NOT EXISTS `MATCH_CARACTERE` (
  `ID_UTILISATEURS` int(30) NOT NULL,
  `ID_CARACTERE` int(11) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`,`ID_CARACTERE`),
  KEY `ID_CARACTERE` (`ID_CARACTERE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MATCH_CARACTERE`
--

INSERT INTO `MATCH_CARACTERE` (`ID_UTILISATEURS`, `ID_CARACTERE`) VALUES
(60, 1),
(58, 2),
(64, 3),
(60, 7);

-- --------------------------------------------------------

--
-- Table structure for table `MATCH_COMPETENCES`
--

CREATE TABLE IF NOT EXISTS `MATCH_COMPETENCES` (
  `ID_UTILISATEURS` int(30) NOT NULL,
  `ID_COMPETENCES` int(11) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`,`ID_COMPETENCES`),
  KEY `ID_COMPETENCES` (`ID_COMPETENCES`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MATCH_COMPETENCES`
--

INSERT INTO `MATCH_COMPETENCES` (`ID_UTILISATEURS`, `ID_COMPETENCES`) VALUES
(60, 3),
(64, 3),
(58, 4),
(60, 4);

-- --------------------------------------------------------

--
-- Table structure for table `MATCH_LANGUE`
--

CREATE TABLE IF NOT EXISTS `MATCH_LANGUE` (
  `ID_UTILISATEURS` int(11) NOT NULL,
  `ID_LANGUE` int(11) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`,`ID_LANGUE`),
  KEY `ID_LANGUE` (`ID_LANGUE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MATCH_LANGUE`
--

INSERT INTO `MATCH_LANGUE` (`ID_UTILISATEURS`, `ID_LANGUE`) VALUES
(58, 1),
(60, 1),
(58, 2),
(60, 2),
(58, 3),
(64, 4);

-- --------------------------------------------------------

--
-- Table structure for table `MATCH_OUTILS`
--

CREATE TABLE IF NOT EXISTS `MATCH_OUTILS` (
  `ID_UTILISATEURS` int(30) NOT NULL,
  `ID_OUTILS` int(30) NOT NULL,
  PRIMARY KEY (`ID_UTILISATEURS`,`ID_OUTILS`),
  KEY `ID_OUTILS` (`ID_OUTILS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MATCH_OUTILS`
--

INSERT INTO `MATCH_OUTILS` (`ID_UTILISATEURS`, `ID_OUTILS`) VALUES
(58, 1),
(60, 1),
(58, 2),
(58, 3),
(60, 3),
(64, 4),
(58, 6);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_expediteur` int(11) NOT NULL DEFAULT '0',
  `id_destinataire` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `titre` text NOT NULL,
  `message` text NOT NULL,
  `signalement_motif` text NOT NULL,
  `signalement_msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `id_expediteur`, `id_destinataire`, `date`, `titre`, `message`, `signalement_motif`, `signalement_msg`) VALUES
(78, 52, 53, '2019-06-07 14:26:42', 'fromage', 'bonjour', '', ''),
(82, 62, 63, '2019-06-08 11:37:02', 'lu', 'salut fred', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `OUTILS`
--

CREATE TABLE IF NOT EXISTS `OUTILS` (
  `ID_OUTILS` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(60) NOT NULL,
  PRIMARY KEY (`ID_OUTILS`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `OUTILS`
--

INSERT INTO `OUTILS` (`ID_OUTILS`, `NOM`) VALUES
(1, 'Powerpoint'),
(2, 'Word'),
(3, 'Excel'),
(4, 'Circuit Maker'),
(5, 'LabView'),
(6, 'Scilab');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE IF NOT EXISTS `publication` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `texte` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`id`, `auteur`, `date`, `texte`) VALUES
(32, 'tempo Thomas', '2019-06-07 14:35:36', 'Bienvenue sur le rÃ©seau\r\n'),
(33, 'Mathis Gourc', '2019-06-07 14:37:00', 'Test'),
(34, 'Donald Duck', '2019-06-07 14:50:02', 'Quand je m''exprime ... '),
(35, 'Mathis Gourc', '2019-06-07 15:22:08', 'â–’â–’â–’â–’â–’â–’â–’â–ˆâ–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–€â–ˆ\r\nâ–’â–’â–’â–’â–’â–’â–’â–ˆâ–‘â–’â–’â–’â–’â–’â–’â–’â–“â–’â–’â–“â–’â–’â–’â–’â–’â–’â–’â–‘â–ˆ\r\nâ–’â–’â–’â–’â–’â–’â–’â–ˆâ–‘â–’â–’â–“â–’â–’â–’â–’â–’â–’â–’â–’â–’â–„â–„â–’â–“â–’â–’â–‘â–ˆâ–‘â–„â–„\r\nâ–’â–’â–„â–€â–€â–„â–„â–ˆâ–‘â–’â–’â–’â–’â–’â–’â–“â–’â–’â–’â–’â–ˆâ–‘â–‘â–€â–„â–„â–„â–„â–„â–€â–‘â–‘â–ˆ\r\nâ–’â–’â–ˆâ–‘â–‘â–‘â–‘â–ˆâ–‘â–’â–’â–’â–’â–’â–’â–’â–’â–’â–’â–’â–ˆâ–‘â–‘â–‘â–‘â–‘â–‘â–‘â–‘â–‘â–‘â–‘â–ˆ\r\nâ–’â–’â–’â–€â–€â–„â–„â–ˆâ–‘â–’â–’â–’â–’â–“â–’â–’â–’â–“â–’â–ˆâ–‘â–‘â–‘â–ˆâ–’â–‘â–‘â–‘â–‘â–ˆâ–’â–‘â–‘â–ˆ\r\nâ–’â–’â–’â–’â–’â–’â–’â–ˆâ–‘â–’â–“â–’â–’â–’â–’â–“â–’â–’â–’â–ˆâ–‘â–‘â–‘â–‘â–‘â–‘â–‘â–€â–‘â–‘â–‘â–‘â–‘â–ˆ\r\nâ–’â–’â–’â–’â–’â–„â–„â–ˆâ–‘â–’â–’â–’â–“â–’â–’â–’â–’â–’â–’â–’â–ˆâ–‘â–‘â–ˆâ–„â–„â–ˆâ–„â–„â–ˆâ–‘â–‘â–ˆ\r\nâ–’â–’â–’â–’â–ˆâ–‘â–‘â–‘â–ˆâ–„â–„â–„â–„â–„â–„â–„â–„â–„â–„â–ˆâ–‘â–ˆâ–„â–„â–„â–„â–„â–„â–„â–„â–„â–ˆ\r\nâ–’â–’â–’â–’â–ˆâ–„â–„â–ˆâ–‘â–‘â–ˆâ–„â–„â–ˆâ–‘â–‘â–‘â–‘â–‘â–‘â–ˆâ–„â–„â–ˆâ–‘â–‘â–ˆâ–„â–„â–ˆ'),
(36, 'Mathis Gourc', '2019-06-07 16:21:30', 'je mets un truc constructif.');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AMIS`
--
ALTER TABLE `AMIS`
  ADD CONSTRAINT `AMIS_ibfk_3` FOREIGN KEY (`ID_UTILISATEURS`) REFERENCES `EISTI_BOOK_UTILISATEUR` (`ID_UTILISATEURS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `MATCH_CARACTERE`
--
ALTER TABLE `MATCH_CARACTERE`
  ADD CONSTRAINT `MATCH_CARACTERE_ibfk_5` FOREIGN KEY (`ID_UTILISATEURS`) REFERENCES `EISTI_BOOK_UTILISATEUR` (`ID_UTILISATEURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MATCH_CARACTERE_ibfk_2` FOREIGN KEY (`ID_CARACTERE`) REFERENCES `CARACTERE` (`ID_CARACTERE`);

--
-- Constraints for table `MATCH_COMPETENCES`
--
ALTER TABLE `MATCH_COMPETENCES`
  ADD CONSTRAINT `MATCH_COMPETENCES_ibfk_5` FOREIGN KEY (`ID_UTILISATEURS`) REFERENCES `EISTI_BOOK_UTILISATEUR` (`ID_UTILISATEURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MATCH_COMPETENCES_ibfk_2` FOREIGN KEY (`ID_COMPETENCES`) REFERENCES `COMPETENCES` (`ID_COMPETENCES`);

--
-- Constraints for table `MATCH_LANGUE`
--
ALTER TABLE `MATCH_LANGUE`
  ADD CONSTRAINT `MATCH_LANGUE_ibfk_5` FOREIGN KEY (`ID_UTILISATEURS`) REFERENCES `EISTI_BOOK_UTILISATEUR` (`ID_UTILISATEURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MATCH_LANGUE_ibfk_2` FOREIGN KEY (`ID_LANGUE`) REFERENCES `LANGUE` (`ID_LANGUE`);

--
-- Constraints for table `MATCH_OUTILS`
--
ALTER TABLE `MATCH_OUTILS`
  ADD CONSTRAINT `MATCH_OUTILS_ibfk_5` FOREIGN KEY (`ID_UTILISATEURS`) REFERENCES `EISTI_BOOK_UTILISATEUR` (`ID_UTILISATEURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `MATCH_OUTILS_ibfk_2` FOREIGN KEY (`ID_OUTILS`) REFERENCES `OUTILS` (`ID_OUTILS`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;