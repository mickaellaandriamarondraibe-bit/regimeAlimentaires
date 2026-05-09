DROP DATABASE IF EXISTS regime_app;

CREATE DATABASE IF NOT EXISTS regime_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE regime_app;

DROP TABLE IF EXISTS demande_code;
DROP TABLE IF EXISTS code;
DROP TABLE IF EXISTS programme_sport;
DROP TABLE IF EXISTS programme;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS regime_sports;
DROP TABLE IF EXISTS sport;
DROP TABLE IF EXISTS composition_regimes;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS prix_regimes;
DROP TABLE IF EXISTS regimes;
DROP TABLE IF EXISTS objectif;
DROP TABLE IF EXISTS infos_clients;
DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('client', 'admin') NOT NULL DEFAULT 'client',
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS infos_clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    phone VARCHAR(30),
    date_naissance DATE, 
    genre ENUM('H', 'F') NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    is_gold BOOLEAN NOT NULL DEFAULT FALSE,
    wallet DECIMAL(10,2) NOT NULL DEFAULT 0,

    CONSTRAINT fk_infos_user
        FOREIGN KEY (user_id) REFERENCES user(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    variation_poids_semaine DECIMAL(6,3) NOT NULL,
    objectif_id INT NOT NULL,

    CONSTRAINT fk_objectif_regime
        FOREIGN KEY (objectif_id) REFERENCES objectif(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS composition_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0.0,
    
    CONSTRAINT fk_composition_regime_id
        FOREIGN KEY (regime_id) REFERENCES regimes(id)
        ON DELETE CASCADE,
    
    CONSTRAINT fk_regime_ingredient_id
        FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
        ON DELETE CASCADE,

    CONSTRAINT uq_composition UNIQUE(regime_id, ingredient_id),

    CONSTRAINT chk_pourcentage_valide
        CHECK (pourcentage >= 0 AND pourcentage <= 100)
);

CREATE TABLE IF NOT EXISTS prix_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    duree_semaine INT NOT NULL,
    prix DECIMAL(10, 2),

    CONSTRAINT fk_prix_regime
        FOREIGN KEY (regime_id) REFERENCES regimes(id)
        ON DELETE CASCADE,

    CONSTRAINT uq_prix_regime UNIQUE(regime_id, duree_semaine),

    CONSTRAINT chk_prix_positif
        CHECK (prix >= 0)
);

CREATE TABLE IF NOT EXISTS sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    variation_poids_semaine DECIMAL(6,3) NOT NULL
);

CREATE TABLE IF NOT EXISTS regime_sports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    sport_id INT NOT NULL,

    CONSTRAINT fk_regime_sport
        FOREIGN KEY (regime_id) REFERENCES regimes(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_sport_regime
        FOREIGN KEY (sport_id) REFERENCES sport(id)
        ON DELETE CASCADE,

    CONSTRAINT uq_regime_sport UNIQUE(regime_id, sport_id)
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type ENUM('D', 'C') NOT NULL,
    client_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_transaction_client
        FOREIGN KEY (client_id) REFERENCES infos_clients(id)
        ON DELETE CASCADE,

    CONSTRAINT chk_montant_positif
        CHECK (montant > 0)
);

CREATE TABLE IF NOT EXISTS programme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objectif_id INT NOT NULL,
    objectif_kg DECIMAL(6,2) NOT NULL,
    duree_semaine INT NOT NULL,
    prix_total DECIMAL(10,2) NOT NULL DEFAULT 0.0,
    poids_initial DECIMAL(6,2) NULL,
    poids_cible DECIMAL(6,2) NULL,
    imc_initial DECIMAL(5,2) NULL,
    date_programme DATETIME DEFAULT CURRENT_TIMESTAMP,
    transaction_id INT,
    client_id INT NOT NULL,
    regime_id INT NOT NULL,

    CONSTRAINT fk_programme_objectif
        FOREIGN KEY (objectif_id) REFERENCES objectif(id),

    CONSTRAINT fk_programme_transaction
        FOREIGN KEY (transaction_id) REFERENCES transactions(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_programme_client
        FOREIGN KEY (client_id) REFERENCES infos_clients(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_programme_regime
        FOREIGN KEY (regime_id) REFERENCES regimes(id),

    CONSTRAINT chk_prix_positif
        CHECK (prix_total >= 0)
);

CREATE TABLE IF NOT EXISTS programme_sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    programme_id INT NOT NULL,
    sport_id INT NOT NULL,

    CONSTRAINT fk_programme_sport_programme
        FOREIGN KEY (programme_id) REFERENCES programme(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_programme_sport_sport
        FOREIGN KEY (sport_id) REFERENCES sport(id)
        ON DELETE CASCADE,

    CONSTRAINT uq_programme_sport   
        UNIQUE (programme_id, sport_id)
);

CREATE TABLE IF NOT EXISTS code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    montant DECIMAL(10,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS demande_code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_id INT NOT NULL,
    statut ENUM('en_attente', 'valide', 'refuse') NOT NULL DEFAULT 'en_attente',
    client_id INT NOT NULL,
    validated_by INT NULL,
    validated_at DATETIME NULL,

    CONSTRAINT fk_demande_code_code
        FOREIGN KEY (code_id) REFERENCES code(id),

    CONSTRAINT fk_demande_code_client
        FOREIGN KEY (client_id) REFERENCES infos_clients(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_demande_code_admin
        FOREIGN KEY (validated_by) REFERENCES user(id)
        ON DELETE SET NULL
);