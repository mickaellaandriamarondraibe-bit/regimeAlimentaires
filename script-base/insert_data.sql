USE regime_app;

/* =========================
   RESET DES DONNEES
========================= */
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE demande_code;
TRUNCATE TABLE code;
TRUNCATE TABLE programme_sport;
TRUNCATE TABLE programme;
TRUNCATE TABLE transactions;
TRUNCATE TABLE regime_sports;
TRUNCATE TABLE sport;
TRUNCATE TABLE composition_regimes;
TRUNCATE TABLE ingredients;
TRUNCATE TABLE prix_regimes;
TRUNCATE TABLE regimes;
TRUNCATE TABLE objectif;
TRUNCATE TABLE infos_clients;
TRUNCATE TABLE user;
TRUNCATE TABLE parametres;
SET FOREIGN_KEY_CHECKS = 1;

/* =========================
   USERS + INFOS CLIENTS
========================= */
INSERT INTO user (id, email, role, password) VALUES
(1, 'admin@nutrifit.mg', 'admin', '$2y$10$0558a2CACKvqrAtal95cE.5T1ekkzC70pT.3YzEE.y2XmwLjrOHWe'),
(2, 'alice@nutrifit.mg', 'client', '$2y$10$URLcUf9IY/AGfqpsvGWQTeZSlQQBKOX.jSjXn7u8cXd3wGtl7L9C2'),
(3, 'bob@nutrifit.mg', 'client', '$2y$10$URLcUf9IY/AGfqpsvGWQTeZSlQQBKOX.jSjXn7u8cXd3wGtl7L9C2'),
(4, 'clara@nutrifit.mg', 'client', '$2y$10$URLcUf9IY/AGfqpsvGWQTeZSlQQBKOX.jSjXn7u8cXd3wGtl7L9C2');

INSERT INTO infos_clients (
    id, user_id, username, phone, date_naissance, genre, taille, poids, age, is_gold, wallet
) VALUES
(1, 1, 'admin', '0340000001', '1990-01-01', 'H', 175.00, 78.00, 36, 1, 150000.00),
(2, 2, 'alice', '0340000002', '1999-05-10', 'F', 162.00, 71.50, 27, 0, 120000.00),
(3, 3, 'bob', '0340000003', '1996-11-15', 'H', 178.00, 64.00, 29, 1, 95000.00),
(4, 4, 'clara', '0340000004', '2001-02-21', 'F', 168.00, 59.00, 25, 0, 60000.00);

/* =========================
   OBJECTIFS
========================= */
INSERT INTO objectif (id, name) VALUES
(1, 'Réduire le poids'),
(2, 'Augmenter le poids'),
(3, 'Atteinte de l\'IMC idéal');

/* =========================
   INGREDIENTS
========================= */
INSERT INTO ingredients (id, name) VALUES
(1, 'Volaille'),
(2, 'Viande'),
(3, 'Poisson'),
(4, 'Legumes verts'),
(5, 'Fruits'),
(6, 'Riz complet');

/* =========================
   REGIMES
========================= */
INSERT INTO regimes (id, name, description, variation_poids_semaine) VALUES
(1, 'Regime Lean Cut', 'Regime hypocalorique riche en proteines maigres.', -0.80),
(2, 'Regime Equilibre Plus', 'Regime modere pour stabilisation et progression douce.', -0.30),
(3, 'Regime Mass Gain', 'Regime hypercalorique pour prise de masse.', 0.65),
(4, 'Regime Active Boost', 'Regime energique pour profils tres actifs.', 0.45);

/* =========================
   COMPOSITION REGIMES
========================= */
INSERT INTO composition_regimes (regime_id, ingredient_id, pourcentage) VALUES
(1, 1, 30.00), (1, 3, 30.00), (1, 4, 25.00), (1, 5, 15.00),
(2, 1, 20.00), (2, 2, 15.00), (2, 3, 20.00), (2, 4, 25.00), (2, 5, 10.00), (2, 6, 10.00),
(3, 2, 30.00), (3, 3, 20.00), (3, 6, 35.00), (3, 5, 15.00),
(4, 1, 25.00), (4, 2, 20.00), (4, 4, 20.00), (4, 6, 35.00);

/* =========================
   PRIX REGIMES
========================= */
INSERT INTO prix_regimes (id, regime_id, duree_semaine, prix) VALUES
(1, 1, 4, 80000.00), (2, 1, 8, 150000.00), (3, 1, 12, 210000.00),
(4, 2, 4, 70000.00), (5, 2, 8, 130000.00), (6, 2, 12, 185000.00),
(7, 3, 4, 90000.00), (8, 3, 8, 170000.00), (9, 3, 12, 240000.00),
(10, 4, 4, 85000.00), (11, 4, 8, 160000.00), (12, 4, 12, 225000.00);

/* =========================
   SPORTS
========================= */
INSERT INTO sport (id, name, description, variation_poids_semaine) VALUES
(1, 'Marche rapide', '30 a 45 minutes par jour.', -0.25),
(2, 'Cardio HIIT', 'Sessions intenses fractionnees.', -0.55),
(3, 'Musculation', 'Renforcement et prise de masse.', 0.30),
(4, 'Yoga dynamique', 'Mobilite, gainage et recuperation.', -0.10),
(5, 'Cross training', 'Melange cardio-force.', 0.15);

/* =========================
   ASSOCIATIONS REGIME-SPORT
========================= */
INSERT INTO regime_sports (regime_id, sport_id) VALUES
(1, 1), (1, 2), (1, 4),
(2, 1), (2, 4), (2, 5),
(3, 3), (3, 5),
(4, 3), (4, 5), (4, 1);

/* =========================
   CODES + DEMANDES CODES
========================= */
INSERT INTO code (id, code, montant) VALUES
(1, 'WELCOME-10K', 10000.00),
(2, 'GOLD-25K', 25000.00),
(3, 'BOOST-50K', 50000.00);

INSERT INTO demande_code (id, code_id, statut, client_id, validated_by, validated_at) VALUES
(1, 1, 'valide', 2, 1, '2026-04-10 10:30:00'),
(2, 2, 'en_attente', 3, NULL, NULL),
(3, 3, 'refuse', 4, 1, '2026-04-15 17:00:00');

/* =========================
   TRANSACTIONS
========================= */
INSERT INTO transactions (id, date, type, client_id, montant) VALUES
(1, '2026-04-10 10:35:00', 'C', 2, 10000.00),
(2, '2026-04-11 08:40:00', 'D', 2, 80000.00),
(3, '2026-04-12 12:00:00', 'D', 3, 90000.00),
(4, '2026-04-14 09:15:00', 'C', 1, 170000.00),
(5, '2026-04-15 16:10:00', 'D', 4, 70000.00);

/* =========================
   PROGRAMMES + PROGRAMME SPORT
========================= */
INSERT INTO programme (
    id, objectif_id, objectif_kg, duree_semaine, prix_total,
    poids_initial, poids_cible, imc_initial, date_programme,
    transaction_id, client_id, regime_id
) VALUES
(1, 1, 5.00, 8, 150000.00, 71.50, 66.50, 27.24, '2026-04-11 08:45:00', 2, 2, 1),
(2, 2, 4.00, 8, 161500.00, 64.00, 68.00, 20.20, '2026-04-12 12:05:00', 3, 3, 3),
(3, 1, 3.00, 4, 70000.00, 59.00, 56.00, 20.90, '2026-04-15 16:15:00', 5, 4, 2);

INSERT INTO programme_sport (programme_id, sport_id) VALUES
(1, 2),
(2, 3),
(3, 1);

/* =========================
   PARAMETRES
========================= */
INSERT INTO parametres (id, cle, valeur, description) VALUES
(1, 'imc_ideal', '22', 'Valeur IMC cible utilisee pour les suggestions.'),
(2, 'reduction_gold', '5', 'Reduction en pourcentage appliquee aux clients Gold.');

/* Comptes de test:
   admin@nutrifit.mg / admin123
   alice@nutrifit.mg / client123
   bob@nutrifit.mg   / client123
   clara@nutrifit.mg / client123
*/
