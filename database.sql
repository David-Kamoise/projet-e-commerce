-- ======================================================
-- Script SQL de création de la base de données - Exemple
-- Projet E-Commerce BTS SIO 1
-- IMPORTANT : Ceci est un exemple avec des tables "foo"
-- À adapter selon votre projet réel
-- ======================================================

-- Suppression de la base si elle existe déjà (ATTENTION en production !)
DROP DATABASE IF EXISTS tahitigame;

-- Création de la base de données
CREATE DATABASE tahitigame CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données
USE tahitigame;

-- ======================================================
-- TABLE : foos
-- Exemple de table d'entités
-- IMPORTANT : Ceci est un exemple générique très simplifié
-- Pour votre projet, adaptez la structure à vos besoins
-- ======================================================
CREATE TABLE foos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- DONNÉES DE TEST - FOOS
-- ======================================================
INSERT INTO foos (nom, description) VALUES
('Foo Alpha', 'Description du Foo Alpha'),
('Foo Beta', 'Description du Foo Beta'),
('Foo Gamma', 'Description du Foo Gamma'),
('Foo Delta', 'Description du Foo Delta'),
('Foo Epsilon', 'Description du Foo Epsilon'),
('Foo Zeta', 'Description du Foo Zeta'),
('Foo Eta', 'Description du Foo Eta'),
('Foo Theta', 'Description du Foo Theta');

-- ======================================================
-- REQUÊTES UTILES POUR LES ÉTUDIANTS
-- ======================================================

-- Afficher tous les foos
-- SELECT * FROM foos;

-- Rechercher un foo par nom
-- SELECT * FROM foos WHERE nom LIKE '%Alpha%';

-- Compter le nombre de foos
-- SELECT COUNT(*) AS total FROM foos;

-- Trier les foos par nom
-- SELECT * FROM foos ORDER BY nom ASC;

-- ======================================================
-- TABLE : categories
-- Gère les catégories de produits
-- ======================================================
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : produits
-- Gère les produits disponibles à la vente
-- MODULE 1 (Binôme 1)
-- ======================================================
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(200) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    categorie_id INT,
    image VARCHAR(255) DEFAULT 'default.jpg',
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_categorie (categorie_id),
    INDEX idx_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : clients
-- Gère les comptes clients
-- MODULE 2 (Binôme 2)
-- ======================================================
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    adresse VARCHAR(255),
    ville VARCHAR(100),
    code_postal VARCHAR(10),
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : commandes
-- Gère les commandes passées par les clients
-- MODULE 3 (Binôme 3)
-- ======================================================
CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en_attente', 'validee', 'expediee', 'livree', 'annulee') DEFAULT 'en_attente',
    montant_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    INDEX idx_client (client_id),
    INDEX idx_statut (statut),
    INDEX idx_date (date_commande)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : lignes_commande
-- Détaille les produits contenus dans chaque commande
-- MODULE 3 (Binôme 3)
-- ======================================================
CREATE TABLE lignes_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE RESTRICT,
    INDEX idx_commande (commande_id),
    INDEX idx_produit (produit_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : paniers
-- Gère les paniers des clients
-- MODULE 4 (Binôme 4)
-- ======================================================
CREATE TABLE paniers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    INDEX idx_client (client_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- TABLE : lignes_panier
-- Détaille les produits contenus dans chaque panier
-- MODULE 4 (Binôme 4)
-- ======================================================
CREATE TABLE lignes_panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (panier_id) REFERENCES paniers(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
    INDEX idx_panier (panier_id),
    INDEX idx_produit (produit_id),
    UNIQUE KEY unique_panier_produit (panier_id, produit_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- DONNÉES DE TEST - CATEGORIES
-- ======================================================
INSERT INTO categories (nom, description) VALUES
('Jeux vidéo', 'Jeux vidéo d\'occasion toutes plateformes'),
('Consoles', 'Consoles de jeux neuves et d\'occasion'),
('Accessoires', 'Accessoires gaming (manettes, casques, etc.)'),
('Retro', 'Jeux et consoles rétro'),
('PC Gaming', 'Composants et jeux pour PC');

-- ======================================================
-- DONNÉES DE TEST - PRODUITS
-- ======================================================
INSERT INTO produits (nom, description, prix, stock, categorie_id, image) VALUES
('The Legend of Zelda: Breath of the Wild', 'Jeu d\'aventure en monde ouvert pour Nintendo Switch. État excellent.', 39.99, 15, 1, 'zelda-botw.jpg'),
('God of War', 'Action-aventure épique sur PlayStation 4. Complet avec boîtier.', 29.99, 8, 1, 'god-of-war.jpg'),
('Elden Ring', 'RPG d\'action pour PC, PS5 et Xbox Series. Neuf sous blister.', 49.99, 12, 1, 'elden-ring.jpg'),
('Nintendo Switch OLED', 'Console Nintendo Switch modèle OLED. Neuve garantie 2 ans.', 349.99, 5, 2, 'switch-oled.jpg'),
('PlayStation 5', 'Console Sony PS5 édition standard. Neuve avec manette.', 499.99, 3, 2, 'ps5.jpg'),
('Xbox Series X', 'Console Microsoft Xbox Series X. État neuf.', 479.99, 4, 2, 'xbox-series-x.jpg'),
('Manette DualSense', 'Manette sans fil pour PS5. Plusieurs coloris disponibles.', 69.99, 20, 3, 'dualsense.jpg'),
('Casque SteelSeries Arctis 7', 'Casque gaming sans fil haute qualité. Compatible toutes plateformes.', 149.99, 10, 3, 'arctis-7.jpg'),
('Super Nintendo Classic Mini', 'Console rétro avec 21 jeux préinstallés.', 89.99, 6, 4, 'snes-classic.jpg'),
('Pokémon Rouge', 'Cartouche Game Boy originale. État correct.', 59.99, 2, 4, 'pokemon-rouge.jpg'),
('RTX 4070 Ti', 'Carte graphique NVIDIA GeForce RTX 4070 Ti. Neuve.', 799.99, 7, 5, 'rtx-4070ti.jpg'),
('Cyberpunk 2077', 'RPG futuriste pour PC. Version complète avec DLC.', 34.99, 18, 5, 'cyberpunk-2077.jpg');

-- ======================================================
-- DONNÉES DE TEST - CLIENTS
-- ======================================================
-- IMPORTANT : Les mots de passe sont hashés avec password_hash()
-- Mot de passe pour tous : "Password123"
-- Hash : $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

INSERT INTO clients (nom, prenom, email, mot_de_passe, telephone, adresse, ville, code_postal) VALUES
('Dupont', 'Jean', 'jean.dupont@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0601020304', '12 rue de la Paix', 'Paris', '75001'),
('Martin', 'Sophie', 'sophie.martin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0612345678', '45 avenue des Champs', 'Lyon', '69001'),
('Bernard', 'Lucas', 'lucas.bernard@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0623456789', '8 boulevard Victor Hugo', 'Marseille', '13001'),
('Petit', 'Emma', 'emma.petit@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0634567890', '23 rue du Commerce', 'Toulouse', '31000'),
('Leroy', 'Thomas', 'thomas.leroy@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0645678901', '67 avenue de la République', 'Nice', '06000');

-- ======================================================
-- DONNÉES DE TEST - COMMANDES
-- ======================================================
INSERT INTO commandes (client_id, date_commande, statut, montant_total) VALUES
(1, '2024-01-15 10:30:00', 'livree', 119.98),
(2, '2024-01-20 14:15:00', 'expediee', 499.99),
(3, '2024-01-25 09:45:00', 'validee', 89.98),
(1, '2024-02-01 16:20:00', 'en_attente', 349.99),
(4, '2024-02-05 11:00:00', 'livree', 69.99);

-- ======================================================
-- DONNÉES DE TEST - LIGNES DE COMMANDE
-- ======================================================
INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire) VALUES
-- Commande 1 (Jean Dupont)
(1, 1, 1, 39.99),  -- Zelda BOTW
(1, 2, 1, 29.99),  -- God of War
(1, 7, 1, 49.99),  -- Manette DualSense

-- Commande 2 (Sophie Martin)
(2, 5, 1, 499.99), -- PlayStation 5

-- Commande 3 (Lucas Bernard)
(3, 9, 1, 89.98),  -- SNES Classic Mini

-- Commande 4 (Jean Dupont)
(4, 4, 1, 349.99), -- Switch OLED

-- Commande 5 (Emma Petit)
(5, 7, 1, 69.99);  -- Manette DualSense

-- ======================================================
-- DONNÉES DE TEST - PANIERS
-- ======================================================
INSERT INTO paniers (client_id) VALUES
(1),  -- Panier de Jean Dupont
(2),  -- Panier de Sophie Martin
(5);  -- Panier de Thomas Leroy

-- ======================================================
-- DONNÉES DE TEST - LIGNES DE PANIER
-- ======================================================
INSERT INTO lignes_panier (panier_id, produit_id, quantite) VALUES
-- Panier 1 (Jean Dupont)
(1, 3, 1),   -- Elden Ring
(1, 12, 2),  -- Cyberpunk 2077

-- Panier 2 (Sophie Martin)
(2, 8, 1),   -- Casque Arctis 7

-- Panier 3 (Thomas Leroy)
(3, 11, 1),  -- RTX 4070 Ti
(3, 6, 1);   -- Xbox Series X

-- ======================================================
-- REQUÊTES UTILES POUR LES ÉTUDIANTS
-- ======================================================

-- Afficher tous les produits avec leur catégorie
-- SELECT p.*, c.nom AS categorie_nom FROM produits p LEFT JOIN categories c ON p.categorie_id = c.id;

-- Afficher toutes les commandes avec le nom du client
-- SELECT co.*, cl.nom, cl.prenom FROM commandes co JOIN clients cl ON co.client_id = cl.id;

-- Afficher le détail d'une commande (produits + quantités)
-- SELECT lc.*, p.nom, p.prix FROM lignes_commande lc JOIN produits p ON lc.produit_id = p.id WHERE lc.commande_id = 1;

-- Calculer le montant total d'un panier
-- SELECT SUM(p.prix * lp.quantite) AS total FROM lignes_panier lp JOIN produits p ON lp.produit_id = p.id WHERE lp.panier_id = 1;

-- Trouver les produits en rupture de stock
-- SELECT * FROM produits WHERE stock = 0;

-- Compter le nombre de commandes par statut
-- SELECT statut, COUNT(*) AS nombre FROM commandes GROUP BY statut;

-- ======================================================
-- FIN DU SCRIPT SQL
-- ======================================================
