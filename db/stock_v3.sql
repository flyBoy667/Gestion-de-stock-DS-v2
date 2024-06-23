-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 27 fév. 2020 à 08:52
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP :  7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `stock_v3`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `categorie` varchar(65) NOT NULL,
  `ajouter_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `categorie`, `ajouter_par`, `created_at`) VALUES
(2, 'T-shirt', 1, '2019-11-20 01:35:33'),
(5, 'Basket', 0, '2019-11-20 13:27:02'),
(7, 'Chemise ', 0, '2019-11-26 12:23:35'),
(8, 'Soulier', 0, '2019-12-03 22:44:46');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `IdClient` int(10) NOT NULL,
  `Client_civilite` varchar(8) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `Tel` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`IdClient`, `Client_civilite`, `Nom`, `Prenom`, `Adresse`, `Tel`) VALUES
(1, 'Mr', 'SATAO', 'Ousmane', 'Kati', '78628587'),
(2, 'Mr', 'Diallo', 'Cheick', 'Bamako', '73259562'),
(4, 'Mme', 'SATAO', 'Marie', 'google', '78628587'),
(5, 'Mme', 'KAMISSOKO', 'TEST', NULL, NULL),
(6, 'Mr', 'DIALLO', 'Hassey', NULL, NULL),
(7, 'Mr', 'CISSE', 'Aba', NULL, NULL),
(8, 'Mr', 'Koné', 'Lacina', NULL, NULL),
(9, 'Mr', 'Cisse', 'Abdoulaye', NULL, NULL),
(10, 'Mr', 'Bambara', 'Kassim', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `Com_num` int(11) NOT NULL,
  `Com_client` int(11) NOT NULL,
  `Com_date` varchar(10) NOT NULL,
  `Com_montant` float NOT NULL,
  `facture_number` varchar(20) NOT NULL,
  `Com_remise` decimal(7,2) NOT NULL DEFAULT 0.00,
  `montant_paye` decimal(8,2) NOT NULL,
  `Ajouter_pat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`Com_num`, `Com_client`, `Com_date`, `Com_montant`, `facture_number`, `Com_remise`, `montant_paye`, `Ajouter_pat`) VALUES
(1, 1, '04/01/2020', 725000, '04/01/2020/A-001', '0.00', '725000.00', NULL),
(2, 2, '05/01/2020', 70000, '05/01/2020/S-002', '0.00', '70000.00', NULL),
(3, 1, '05/01/2020', 50000, '05/01/2020/S-003', '0.00', '50000.00', NULL),
(4, 10, '30/01/2020', 45000, '30/01/2020/S-004', '0.00', '45000.00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE `depense` (
  `id_depense` int(11) NOT NULL,
  `motif` varchar(100) NOT NULL,
  `montant` decimal(9,2) NOT NULL,
  `ajouter_par` int(11) DEFAULT NULL,
  `depense_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`id_depense`, `motif`, `montant`, `ajouter_par`, `depense_date`) VALUES
(1, 'Paiement électricité', '50000.00', NULL, '2020-01-05 01:09:06'),
(2, 'Achat de déjeuner', '5000.00', NULL, '2020-01-30 20:00:16'),
(3, 'Achat de dîner', '3000.00', NULL, '2020-01-30 20:01:01');

-- --------------------------------------------------------

--
-- Structure de la table `detail`
--

CREATE TABLE `detail` (
  `Detail_num` int(11) NOT NULL,
  `Detail_com` varchar(20) NOT NULL,
  `Detail_ref` varchar(10) NOT NULL,
  `Detail_qte` smallint(6) NOT NULL,
  `type` int(1) NOT NULL,
  `date_commande` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail`
--

INSERT INTO `detail` (`Detail_num`, `Detail_com`, `Detail_ref`, `Detail_qte`, `type`, `date_commande`) VALUES
(1, '04/01/2020/A-001', '1', 10, 2, '2020-01-04'),
(2, '04/01/2020/A-001', '2', 5, 2, '2020-01-04'),
(3, '04/01/2020/A-001', '3', 15, 2, '2020-01-04'),
(4, '05/01/2020/S-002', '1', 1, 1, '2020-01-05'),
(5, '05/01/2020/S-002', '3', 1, 1, '2020-01-05'),
(6, '05/01/2020/S-002', '2', 1, 1, '2020-01-05'),
(7, '05/01/2020/S-003', '1', 2, 1, '2020-01-05'),
(8, '30/01/2020/S-004', '3', 1, 1, '2020-01-30'),
(9, '30/01/2020/S-004', '2', 1, 1, '2020-01-30');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `ref_fournisseur` int(11) NOT NULL,
  `nom_fournisseur` varchar(65) NOT NULL,
  `prenom_fournisseur` varchar(65) NOT NULL,
  `societe` varchar(255) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `telephone` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`ref_fournisseur`, `nom_fournisseur`, `prenom_fournisseur`, `societe`, `adresse`, `telephone`) VALUES
(1, 'DIALLO', 'Cheick', 'Cheick Diallo Consulting', 'Hamdallaye ACI 2000', '91936013'),
(2, 'BAGAYOKO', 'Ablo', 'Ablo Alpha tout', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id_marque` int(11) NOT NULL,
  `marque` varchar(65) NOT NULL,
  `ajouter_par` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `marque`, `ajouter_par`, `created_at`) VALUES
(1, 'Adidas', 1, '2019-11-20 01:36:15'),
(5, 'Puma', 0, '2019-11-20 13:28:34'),
(6, 'Nike', 0, '2019-11-20 13:28:52'),
(8, 'D&G', 0, '2019-12-03 22:45:08'),
(9, 'Zara', 0, '2020-01-04 20:18:56');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `nom_produit` varchar(100) NOT NULL,
  `code_produit` varchar(13) NOT NULL,
  `categorie` int(11) NOT NULL,
  `marque` int(11) NOT NULL,
  `prix_achat` decimal(8,2) NOT NULL,
  `prix_vente` decimal(8,2) NOT NULL,
  `stock` int(4) NOT NULL DEFAULT 0,
  `stock_encours` int(11) DEFAULT 0,
  `statut` int(1) NOT NULL,
  `image` varchar(65) DEFAULT NULL,
  `ajouter_par` int(11) DEFAULT NULL,
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom_produit`, `code_produit`, `categorie`, `marque`, `prix_achat`, `prix_vente`, `stock`, `stock_encours`, `statut`, `image`, `ajouter_par`, `created_at`) VALUES
(1, 'Puma suede', '001', 5, 5, '17000.00', '25000.00', 0, 7, 1, NULL, NULL, '2020-01-04'),
(2, 'Air Max 200', '002', 5, 6, '12000.00', '20000.00', 0, 3, 1, NULL, NULL, '2020-01-04'),
(3, 'Zara men', '003', 7, 9, '15000.00', '25000.00', 0, 13, 1, NULL, NULL, '2020-01-04'),
(4, 'Soulier Zara men', '004', 8, 9, '30000.00', '45000.00', 0, 0, 1, NULL, NULL, '2020-01-04');

-- --------------------------------------------------------

--
-- Structure de la table `system_group`
--

CREATE TABLE `system_group` (
  `id_group` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `system_group`
--

INSERT INTO `system_group` (`id_group`, `name`, `description`) VALUES
(4, 'user', 'Simple utilisateur du systÃ¨me'),
(5, 'admin', 'Administrateur systÃ¨me');

-- --------------------------------------------------------

--
-- Structure de la table `temp`
--

CREATE TABLE `temp` (
  `Temp_ref` varchar(10) NOT NULL,
  `Temp_qte` int(11) NOT NULL,
  `Temp_designation` varchar(100) NOT NULL,
  `Temp_PUHT` float NOT NULL,
  `Temp_THT` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id_transaction` int(11) NOT NULL,
  `num_facture` varchar(20) NOT NULL,
  `client_fournisseur` int(11) NOT NULL,
  `montant` decimal(9,2) NOT NULL,
  `remise` decimal(9,2) NOT NULL,
  `montant_paye` decimal(9,2) NOT NULL,
  `remarque` text DEFAULT NULL,
  `type` int(1) NOT NULL,
  `transaction_date` varchar(10) DEFAULT NULL,
  `ajouter_par` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `transaction`
--

INSERT INTO `transaction` (`id_transaction`, `num_facture`, `client_fournisseur`, `montant`, `remise`, `montant_paye`, `remarque`, `type`, `transaction_date`, `ajouter_par`) VALUES
(1, '04/01/2020/A-001', 1, '725000.00', '0.00', '725000.00', NULL, 2, '2020-01-04', 0),
(2, '05/01/2020/S-002', 2, '70000.00', '0.00', '70000.00', NULL, 1, '2020-01-05', 0),
(3, '05/01/2020/S-003', 1, '50000.00', '0.00', '50000.00', NULL, 1, '2020-01-05', 0),
(4, '30/01/2020/S-004', 10, '45000.00', '0.00', '45000.00', NULL, 1, '2020-01-30', 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_personnel` int(11) NOT NULL,
  `username` varchar(65) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `nom` varchar(65) DEFAULT NULL,
  `prenom` varchar(65) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ajouter_par` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_personnel`, `username`, `password`, `role`, `nom`, `prenom`, `email`, `ajouter_par`, `created_at`) VALUES
(3, 'hassey', '$2y$10$iWFcFTKHLwo2nwhscjltwOK2BbtZkjReywoHvrzpnQw7XrhtfSiP6', 5, 'DIALLO', 'Cheick', 'diallocheickb@gmail.com', NULL, '2019-11-20 12:20:31'),
(4, 'satao', '$2y$10$.xJdqaByDcb0ZfrC6enk6uMLFOvwqg6g3b3mkT6PfYWrlzCt5pi26', 5, 'SATAO', 'Soumana', 'satao@ds.com', NULL, '2019-12-03 23:53:07');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`IdClient`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`Com_num`),
  ADD KEY `Com_client` (`Com_client`);

--
-- Index pour la table `depense`
--
ALTER TABLE `depense`
  ADD PRIMARY KEY (`id_depense`);

--
-- Index pour la table `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`Detail_num`),
  ADD KEY `Detail_ref` (`Detail_ref`),
  ADD KEY `detail_ibfk_2` (`Detail_com`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`ref_fournisseur`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id_marque`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `system_group`
--
ALTER TABLE `system_group`
  ADD PRIMARY KEY (`id_group`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_transaction`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_personnel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `IdClient` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `Com_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `depense`
--
ALTER TABLE `depense`
  MODIFY `id_depense` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `detail`
--
ALTER TABLE `detail`
  MODIFY `Detail_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `ref_fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `system_group`
--
ALTER TABLE `system_group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id_transaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_personnel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
