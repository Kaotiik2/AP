-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 28 sep. 2023 à 11:54
-- Version du serveur :  10.5.19-MariaDB-0+deb11u2
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `LPFS`
--

-- --------------------------------------------------------

--
-- Structure de la table `civilite`
--

CREATE TABLE `civilite` (
  `id` int(11) NOT NULL,
  `civilite` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `civilite`
--

INSERT INTO `civilite` (`id`, `civilite`) VALUES
(1, 'Monsieur'),
(2, 'Madame'),
(3, 'Autre/Préfère ne pas dire');

-- --------------------------------------------------------

--
-- Structure de la table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `nom_discipline` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `disciplines`
--

INSERT INTO `disciplines` (`id`, `nom_discipline`) VALUES
(1, 'Urologie');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `num_secu` varchar(15) NOT NULL,
  `carte_identite_recto` mediumblob NOT NULL,
  `carte_identite_verso` mediumblob NOT NULL,
  `carte_vitale` mediumblob NOT NULL,
  `carte_mutuelle` mediumblob NOT NULL,
  `livret_famille` mediumblob DEFAULT NULL,
  `autorisation_soin` mediumblob DEFAULT NULL,
  `monoparentalite_juge` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisations`
--

CREATE TABLE `hospitalisations` (
  `num_secu` varchar(15) NOT NULL,
  `date_hospitalisation` date NOT NULL,
  `heure_intervention` date NOT NULL,
  `type_hospitalisation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medecins`
--

CREATE TABLE `medecins` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `discipline` int(11) NOT NULL,
  `id_medecin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecins`
--

INSERT INTO `medecins` (`nom`, `prenom`, `discipline`, `id_medecin`) VALUES
('Descamps', 'Fabien', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `num_secu` varchar(15) NOT NULL,
  `organisme_secu` varchar(100) NOT NULL,
  `assurance` tinyint(1) NOT NULL,
  `ald` tinyint(1) NOT NULL,
  `nom_mutuelle` varchar(100) NOT NULL,
  `num_adherent_mutuelle` varchar(100) NOT NULL,
  `type_chambre` int(11) NOT NULL,
  `civilite` int(11) NOT NULL,
  `nom_naissance` varchar(100) NOT NULL,
  `nom_epouse` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `code_postal` varchar(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnes_a_prevenir`
--

CREATE TABLE `personnes_a_prevenir` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `num_secu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnes_de_confiance`
--

CREATE TABLE `personnes_de_confiance` (
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `num_secu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `postes`
--

CREATE TABLE `postes` (
  `id` int(11) NOT NULL,
  `intitule_poste` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `postes`
--

INSERT INTO `postes` (`id`, `intitule_poste`) VALUES
(1, 'Administrateur'),
(2, 'Médecin'),
(3, 'Secrétariat');

-- --------------------------------------------------------

--
-- Structure de la table `type_chambre`
--

CREATE TABLE `type_chambre` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_chambre`
--

INSERT INTO `type_chambre` (`id`, `type`) VALUES
(1, 'Chambre individuelle'),
(2, 'Chambre double'),
(3, 'Chambre commune');

-- --------------------------------------------------------

--
-- Structure de la table `type_hospitalisation`
--

CREATE TABLE `type_hospitalisation` (
  `id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_hospitalisation`
--

INSERT INTO `type_hospitalisation` (`id`, `type`) VALUES
(1, 'Ambulatoire chirurgie'),
(2, 'Hospitalisation (au moins une nuit)');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `id_poste` int(11) NOT NULL,
  `mot_de_passe` varchar(32) NOT NULL,
  `premiere_connexion` tinyint(1) NOT NULL,
  `date_mdp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `mail`, `date_naissance`, `telephone`, `id_poste`, `mot_de_passe`, `premiere_connexion`, `date_mdp`) VALUES
(1, 'Fabien', 'Descamps', 'fab@gmail.com', '2015-06-07', '0102030405', 1, 'azerty', 0, 1695893115),
(2, 'Grand', 'Mathilde', 'evilmathis@gmail.com', '2023-09-20', '6969696969', 3, 'lucasfilsdepute', 1, 1695371225),
(3, 'Dubrieux', 'Joshua', 'joshua@gmail.com', '2023-09-06', '0606060606', 3, 'azerty', 1, 1695308384);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `civilite`
--
ALTER TABLE `civilite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD KEY `FK_1` (`num_secu`);

--
-- Index pour la table `hospitalisations`
--
ALTER TABLE `hospitalisations`
  ADD KEY `FK_1` (`num_secu`),
  ADD KEY `FK_2` (`type_hospitalisation`);

--
-- Index pour la table `medecins`
--
ALTER TABLE `medecins`
  ADD KEY `FK_1` (`discipline`),
  ADD KEY `FK_2` (`id_medecin`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`num_secu`),
  ADD KEY `FK_1` (`type_chambre`),
  ADD KEY `FK_2` (`civilite`);

--
-- Index pour la table `personnes_a_prevenir`
--
ALTER TABLE `personnes_a_prevenir`
  ADD KEY `FK_1` (`num_secu`);

--
-- Index pour la table `personnes_de_confiance`
--
ALTER TABLE `personnes_de_confiance`
  ADD KEY `FK_1` (`num_secu`);

--
-- Index pour la table `postes`
--
ALTER TABLE `postes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_chambre`
--
ALTER TABLE `type_chambre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_hospitalisation`
--
ALTER TABLE `type_hospitalisation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_1` (`id_poste`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `postes`
--
ALTER TABLE `postes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_hospitalisation`
--
ALTER TABLE `type_hospitalisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `FK_9` FOREIGN KEY (`num_secu`) REFERENCES `patients` (`num_secu`);

--
-- Contraintes pour la table `hospitalisations`
--
ALTER TABLE `hospitalisations`
  ADD CONSTRAINT `FK_11` FOREIGN KEY (`type_hospitalisation`) REFERENCES `type_hospitalisation` (`id`),
  ADD CONSTRAINT `FK_5` FOREIGN KEY (`num_secu`) REFERENCES `patients` (`num_secu`);

--
-- Contraintes pour la table `medecins`
--
ALTER TABLE `medecins`
  ADD CONSTRAINT `FK_7` FOREIGN KEY (`discipline`) REFERENCES `disciplines` (`id`),
  ADD CONSTRAINT `FK_9_1` FOREIGN KEY (`id_medecin`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `FK_1` FOREIGN KEY (`type_chambre`) REFERENCES `type_chambre` (`id`),
  ADD CONSTRAINT `FK_2` FOREIGN KEY (`civilite`) REFERENCES `civilite` (`id`);

--
-- Contraintes pour la table `personnes_a_prevenir`
--
ALTER TABLE `personnes_a_prevenir`
  ADD CONSTRAINT `FK_3` FOREIGN KEY (`num_secu`) REFERENCES `patients` (`num_secu`);

--
-- Contraintes pour la table `personnes_de_confiance`
--
ALTER TABLE `personnes_de_confiance`
  ADD CONSTRAINT `FK_4` FOREIGN KEY (`num_secu`) REFERENCES `patients` (`num_secu`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `FK_10` FOREIGN KEY (`id_poste`) REFERENCES `postes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
