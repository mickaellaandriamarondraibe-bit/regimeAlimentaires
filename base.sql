CREATE DATABASE IF NOT EXISTS regime_app
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE regime_app;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('client', 'admin') NOT NULL DEFAULT 'client',
    password VARCHAR(255) NOT NULL
);

CREATE TABLE infos_clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    genre ENUM('H', 'F') NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    is_gold BOOLEAN NOT NULL DEFAULT FALSE,
    wallet DECIMAL(10,2) NOT NULL DEFAULT 0,

    CONSTRAINT fk_infos_user
        FOREIGN KEY (user_id) REFERENCES user(id)
        ON DELETE CASCADE
);

CREATE TABLE objectif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    type_variation ENUM('gain', 'perte') NOT NULL,
    variation_poids_jour DECIMAL(6,3) NOT NULL,
    prix_jour DECIMAL(10,2) NOT NULL,
);

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE composition_regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0.0
    
    CONSTRAINT fk_composition_regime_id
        FOREIGN KEY (regime_id) REFERENCES regimes(id)
        ON DELETE CASCADE
    
    CONSTRAINT fk_regime_ingredient_id
        FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
        ON DELETE CASCADE
);

CREATE TABLE sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    variation_poids_jour DECIMAL(6,3) NOT NULL
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type ENUM('D', 'C') NOT NULL,
    client_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_transaction_client
        FOREIGN KEY (client_id) REFERENCES infos_clients(id)
        ON DELETE CASCADE
);

CREATE TABLE programme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    objectif_id INT NOT NULL,
    objectif_kg DECIMAL(6,2) NOT NULL,
    duree INT NOT NULL,
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
        FOREIGN KEY (regime_id) REFERENCES regimes(id)
);

CREATE TABLE programme_sport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    programme_id INT NOT NULL,
    sport_id INT NOT NULL,

    CONSTRAINT fk_programme_sport_programme
        FOREIGN KEY (programme_id) REFERENCES programme(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_programme_sport_sport
        FOREIGN KEY (sport_id) REFERENCES sport(id),

    CONSTRAINT uq_programme_sport
        UNIQUE (programme_id, sport_id)
);

CREATE TABLE code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    montant DECIMAL(10,2) NOT NULL
);

CREATE TABLE demande_code (
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