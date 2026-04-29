CREATE DATABASE IF NOT EXISTS note;
USE note;

-- =========================
-- DROP TABLES (ordre correct)
-- =========================
DROP TABLE IF EXISTS note;
DROP TABLE IF EXISTS programme;
DROP TABLE IF EXISTS groupe_ue_element;
DROP TABLE IF EXISTS groupe_ue;
DROP TABLE IF EXISTS ue;
DROP TABLE IF EXISTS etudiant;
DROP TABLE IF EXISTS semestre;
DROP TABLE IF EXISTS parcours;

-- =========================
-- TABLES
-- =========================

CREATE TABLE parcours (
    id INT PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE semestre (
    id INT PRIMARY KEY,
    numero INT
);

CREATE TABLE etudiant (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_etu VARCHAR(50) UNIQUE NOT NULL,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL
);

CREATE TABLE ue (
    id INT PRIMARY KEY,
    code VARCHAR(20),
    libelle VARCHAR(255),
    credits INT
);

CREATE TABLE note (
    id INT PRIMARY KEY AUTO_INCREMENT,
    note DECIMAL(5,2),
    ue_id INT NOT NULL,
    id_etudiant INT NOT NULL,
    semestre_id INT NOT NULL,
    FOREIGN KEY (ue_id) REFERENCES ue(id),
    FOREIGN KEY (id_etudiant) REFERENCES etudiant(id),
    FOREIGN KEY (semestre_id) REFERENCES semestre(id)
);

CREATE TABLE groupe_ue (
    id INT PRIMARY KEY,
    libelle VARCHAR(255),
    nb_choix INT
);

CREATE TABLE groupe_ue_element (
    id INT PRIMARY KEY,
    groupe_ue_id INT,
    ue_id INT,
    FOREIGN KEY (groupe_ue_id) REFERENCES groupe_ue(id),
    FOREIGN KEY (ue_id) REFERENCES ue(id)
);

CREATE TABLE programme (
    id INT PRIMARY KEY,
    parcours_id INT,
    semestre_id INT,
    ue_id INT NULL,
    groupe_ue_id INT NULL,
    FOREIGN KEY (parcours_id) REFERENCES parcours(id),
    FOREIGN KEY (semestre_id) REFERENCES semestre(id),
    FOREIGN KEY (ue_id) REFERENCES ue(id),
    FOREIGN KEY (groupe_ue_id) REFERENCES groupe_ue(id),
    CHECK (
        (ue_id IS NOT NULL AND groupe_ue_id IS NULL)
        OR
        (ue_id IS NULL AND groupe_ue_id IS NOT NULL)
    )
);

-- =========================
-- PARCOURS
-- =========================
INSERT INTO parcours VALUES
(1, 'Développement'),
(2, 'Bases de Données et Réseaux'),
(3, 'Web et Design');

-- =========================
-- SEMESTRES
-- =========================
INSERT INTO semestre VALUES
(1, 3),
(2, 4);

-- =========================
-- ETUDIANTS
-- =========================
INSERT INTO etudiant (numero_etu, nom, prenom) VALUES
('ETU0001', 'Randriamampionona', 'Feno'),
('ETU0002', 'Rakotoarisoa', 'Miora'),
('ETU0003', 'Rasoanaivo', 'Tiana'),
('ETU0004', 'Andrianarivelo', 'Hery'),
('ETU0005', 'Ramanantsoa', 'Soa');

-- =========================
-- UE
-- =========================
INSERT INTO ue VALUES
(1, 'INF201', 'POO', 6),
(2, 'INF202', 'BD Objet', 6),
(3, 'INF203', 'Système', 4),
(4, 'INF208', 'Réseaux', 6),
(5, 'MTH201', 'Méthodes numériques', 4),
(6, 'ORG201', 'Gestion', 4),

(7, 'INF204', 'SIG', 6),
(8, 'INF205', 'SI', 6),
(9, 'INF206', 'IHM', 6),
(10, 'INF207', 'Algo', 6),
(11, 'INF209', 'Web dynamique', 6),

(12, 'INF210', 'Mini Dev', 10),
(13, 'INF211', 'Mini BD', 10),
(14, 'INF212', 'Mini Web', 10),

(15, 'MTH202', 'Analyse données', 4),
(16, 'MTH203', 'MAO', 4),
(17, 'MTH204', 'Géométrie', 4),
(18, 'MTH205', 'EDO', 4),
(19, 'MTH206', 'Optimisation', 4);

-- =========================
-- PROGRAMME S3 (COMMUN)
-- =========================
INSERT INTO programme VALUES
(1, 1, 1, 1, NULL),
(2, 1, 1, 2, NULL),
(3, 1, 1, 3, NULL),
(4, 1, 1, 4, NULL),
(5, 1, 1, 5, NULL),
(6, 1, 1, 6, NULL);

-- =========================
-- GROUPES DEV S4
-- =========================
INSERT INTO groupe_ue VALUES
(1, 'DEV Info', 1),
(2, 'DEV Maths', 1);

INSERT INTO groupe_ue_element VALUES
(1, 1, 7),
(2, 1, 8),
(3, 1, 9),
(4, 1, 10),

(5, 2, 17),
(6, 2, 18),
(7, 2, 19);

-- =========================
-- PROGRAMME DEV S4
-- =========================
INSERT INTO programme VALUES
(10, 1, 2, NULL, 1),
(11, 1, 2, 12, NULL),
(12, 1, 2, NULL, 2),
(13, 1, 2, 8, NULL),
(14, 1, 2, 16, NULL);

-- =========================
-- GROUPES BDR S4
-- =========================
INSERT INTO groupe_ue VALUES
(3, 'BDR Info', 1),
(4, 'BDR Maths', 1);

INSERT INTO groupe_ue_element VALUES
(8, 3, 7),
(9, 3, 9),
(10, 3, 10),

(11, 4, 15),
(12, 4, 18),
(13, 4, 19);

-- =========================
-- PROGRAMME BDR S4
-- =========================
INSERT INTO programme VALUES
(20, 2, 2, 8, NULL),
(21, 2, 2, NULL, 3),
(22, 2, 2, 13, NULL),
(23, 2, 2, NULL, 4),
(24, 2, 2, 16, NULL);

-- =========================
-- GROUPES WEB S4
-- =========================
INSERT INTO groupe_ue VALUES
(5, 'WEB Info', 1),
(6, 'WEB Maths', 1);

INSERT INTO groupe_ue_element VALUES
(14, 5, 7),
(15, 5, 8),
(16, 5, 9),
(17, 5, 11),

(18, 6, 15),
(19, 6, 17),
(20, 6, 19);

-- =========================
-- PROGRAMME WEB S4
-- =========================
INSERT INTO programme VALUES
(30, 3, 2, NULL, 5),
(31, 3, 2, 14, NULL),
(32, 3, 2, NULL, 6),
(33, 3, 2, 11, NULL),
(34, 3, 2, 16, NULL);