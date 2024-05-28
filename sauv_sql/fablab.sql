-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 05 avr. 2024 à 12:17
-- Version du serveur :  8.0.36-0ubuntu0.20.04.1
-- Version de PHP : 7.4.3-4ubuntu2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fablab`
--

-- --------------------------------------------------------

--
-- Structure de la table `AccesEquipements`
--

CREATE TABLE `AccesEquipements` (
  `ID_Acces` int NOT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `ID_Equipement` int DEFAULT NULL,
  `DateHeureAcces` datetime NOT NULL,
  `TypeAcces` enum('Entrée','Sortie') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `CategoriesEquipements`
--

CREATE TABLE `CategoriesEquipements` (
  `ID_Categorie` int NOT NULL,
  `NomCategorie` varchar(255) NOT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Certifications`
--

CREATE TABLE `Certifications` (
  `ID_Certification` int NOT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `ID_Formation` int DEFAULT NULL,
  `DateObtention` date NOT NULL,
  `Score` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Equipements`
--

CREATE TABLE `Equipements` (
  `ID_Equipement` int NOT NULL,
  `NomEquipement` varchar(255) NOT NULL,
  `Description` text,
  `Statut` enum('Disponible','EnPanne','Réservé') NOT NULL,
  `ID_Categorie` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Formations`
--

CREATE TABLE `Formations` (
  `ID_Formation` int NOT NULL,
  `TitreFormation` varchar(255) NOT NULL,
  `Description` text,
  `Contenu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Forums`
--

CREATE TABLE `Forums` (
  `ID_Forum` int NOT NULL,
  `Titre` varchar(255) NOT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MessagesForum`
--

CREATE TABLE `MessagesForum` (
  `ID_Message` int NOT NULL,
  `ID_Forum` int DEFAULT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `ContenuMessage` text,
  `DateHeureMessage` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PannesEquipements`
--

CREATE TABLE `PannesEquipements` (
  `ID_Panne` int NOT NULL,
  `ID_Equipement` int DEFAULT NULL,
  `DescriptionPanne` text,
  `DateHeureSignalement` datetime NOT NULL,
  `StatutPanne` enum('Signalée','EnCoursDeRéparation','Réparée') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Projets`
--

CREATE TABLE `Projets` (
  `ID_Projet` int NOT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `TitreProjet` varchar(255) NOT NULL,
  `DescriptionProjet` text,
  `ImageURL` varchar(255) DEFAULT NULL,
  `DateCreation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Reservations`
--

CREATE TABLE `Reservations` (
  `ID_Reservation` int NOT NULL,
  `ID_Utilisateur` int DEFAULT NULL,
  `ID_Equipement` int DEFAULT NULL,
  `DateHeureDebut` datetime NOT NULL,
  `DateHeureFin` datetime NOT NULL,
  `StatutReservation` enum('Confirmée','Annulée','Terminée') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `ID_Utilisateur` int NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `MotDePasse` varchar(255) NOT NULL,
  `Role` enum('Étudiant','Administrateur','Formateur') NOT NULL,
  `StatutCertification` tinyint(1) DEFAULT '0',
  `uid_rfid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`ID_Utilisateur`, `Nom`, `Prenom`, `Email`, `MotDePasse`, `Role`, `StatutCertification`, `uid_rfid`) VALUES
(1, 'etudiant_1', 'etudiant_1', 'etudiant_1@fablab.com', 'fablab', 'Étudiant', 0, NULL),
(2, 'admin_1', 'admin_1', 'admin_1@fablab.com', 'admin_1', 'Administrateur', 0, NULL),
(3, 'test', 'test', 'test@fablab.com', 'test', 'Administrateur', 0, '1234567890');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `AccesEquipements`
--
ALTER TABLE `AccesEquipements`
  ADD PRIMARY KEY (`ID_Acces`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Equipement` (`ID_Equipement`);

--
-- Index pour la table `CategoriesEquipements`
--
ALTER TABLE `CategoriesEquipements`
  ADD PRIMARY KEY (`ID_Categorie`);

--
-- Index pour la table `Certifications`
--
ALTER TABLE `Certifications`
  ADD PRIMARY KEY (`ID_Certification`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Formation` (`ID_Formation`);

--
-- Index pour la table `Equipements`
--
ALTER TABLE `Equipements`
  ADD PRIMARY KEY (`ID_Equipement`),
  ADD KEY `ID_Categorie` (`ID_Categorie`);

--
-- Index pour la table `Formations`
--
ALTER TABLE `Formations`
  ADD PRIMARY KEY (`ID_Formation`);

--
-- Index pour la table `Forums`
--
ALTER TABLE `Forums`
  ADD PRIMARY KEY (`ID_Forum`);

--
-- Index pour la table `MessagesForum`
--
ALTER TABLE `MessagesForum`
  ADD PRIMARY KEY (`ID_Message`),
  ADD KEY `ID_Forum` (`ID_Forum`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `PannesEquipements`
--
ALTER TABLE `PannesEquipements`
  ADD PRIMARY KEY (`ID_Panne`),
  ADD KEY `ID_Equipement` (`ID_Equipement`);

--
-- Index pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD PRIMARY KEY (`ID_Projet`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`);

--
-- Index pour la table `Reservations`
--
ALTER TABLE `Reservations`
  ADD PRIMARY KEY (`ID_Reservation`),
  ADD KEY `ID_Utilisateur` (`ID_Utilisateur`),
  ADD KEY `ID_Equipement` (`ID_Equipement`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`ID_Utilisateur`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `AccesEquipements`
--
ALTER TABLE `AccesEquipements`
  MODIFY `ID_Acces` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `CategoriesEquipements`
--
ALTER TABLE `CategoriesEquipements`
  MODIFY `ID_Categorie` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Certifications`
--
ALTER TABLE `Certifications`
  MODIFY `ID_Certification` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Equipements`
--
ALTER TABLE `Equipements`
  MODIFY `ID_Equipement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Formations`
--
ALTER TABLE `Formations`
  MODIFY `ID_Formation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Forums`
--
ALTER TABLE `Forums`
  MODIFY `ID_Forum` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MessagesForum`
--
ALTER TABLE `MessagesForum`
  MODIFY `ID_Message` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `PannesEquipements`
--
ALTER TABLE `PannesEquipements`
  MODIFY `ID_Panne` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Projets`
--
ALTER TABLE `Projets`
  MODIFY `ID_Projet` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Reservations`
--
ALTER TABLE `Reservations`
  MODIFY `ID_Reservation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `ID_Utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `AccesEquipements`
--
ALTER TABLE `AccesEquipements`
  ADD CONSTRAINT `AccesEquipements_ibfk_1` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID_Utilisateur`),
  ADD CONSTRAINT `AccesEquipements_ibfk_2` FOREIGN KEY (`ID_Equipement`) REFERENCES `Equipements` (`ID_Equipement`);

--
-- Contraintes pour la table `Certifications`
--
ALTER TABLE `Certifications`
  ADD CONSTRAINT `Certifications_ibfk_1` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID_Utilisateur`),
  ADD CONSTRAINT `Certifications_ibfk_2` FOREIGN KEY (`ID_Formation`) REFERENCES `Formations` (`ID_Formation`);

--
-- Contraintes pour la table `Equipements`
--
ALTER TABLE `Equipements`
  ADD CONSTRAINT `Equipements_ibfk_1` FOREIGN KEY (`ID_Categorie`) REFERENCES `CategoriesEquipements` (`ID_Categorie`);

--
-- Contraintes pour la table `MessagesForum`
--
ALTER TABLE `MessagesForum`
  ADD CONSTRAINT `MessagesForum_ibfk_1` FOREIGN KEY (`ID_Forum`) REFERENCES `Forums` (`ID_Forum`),
  ADD CONSTRAINT `MessagesForum_ibfk_2` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID_Utilisateur`);

--
-- Contraintes pour la table `PannesEquipements`
--
ALTER TABLE `PannesEquipements`
  ADD CONSTRAINT `PannesEquipements_ibfk_1` FOREIGN KEY (`ID_Equipement`) REFERENCES `Equipements` (`ID_Equipement`);

--
-- Contraintes pour la table `Projets`
--
ALTER TABLE `Projets`
  ADD CONSTRAINT `Projets_ibfk_1` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID_Utilisateur`);

--
-- Contraintes pour la table `Reservations`
--
ALTER TABLE `Reservations`
  ADD CONSTRAINT `Reservations_ibfk_1` FOREIGN KEY (`ID_Utilisateur`) REFERENCES `Utilisateurs` (`ID_Utilisateur`),
  ADD CONSTRAINT `Reservations_ibfk_2` FOREIGN KEY (`ID_Equipement`) REFERENCES `Equipements` (`ID_Equipement`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
