
DROP TABLE IF EXISTS programme;
DROP TABLE IF EXISTS groupe_ue_element;
DROP TABLE IF EXISTS groupe_ue;
DROP TABLE IF EXISTS ue;
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

CREATE TABLE ue (
    id INT PRIMARY KEY,
    code VARCHAR(20),
    libelle VARCHAR(255),
    credits INT
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
-- UE
-- =========================
INSERT INTO ue VALUES
(1, 'INF201', 'Programmation orientée objet', 6),
(2, 'INF202', 'Bases de données objets', 6),
(3, 'INF203', 'Programmation système', 4),
(4, 'INF208', 'Réseaux informatiques', 6),
(5, 'MTH201', 'Méthodes numériques', 4),
(6, 'ORG201', 'Bases de gestion', 4),

(7, 'INF204', 'Système d''information géographique', 6),
(8, 'INF205', 'Système d''information', 6),
(9, 'INF206', 'Interface Homme/Machine', 6),
(10, 'INF207', 'Eléments d''algorithmique', 6),
(11, 'INF209', 'Web dynamique', 6),

(12, 'INF210', 'Mini-projet de développement', 10),
(13, 'INF211', 'Mini-projet BD/Réseaux', 10),
(14, 'INF212', 'Mini-projet Web & Design', 10),

(15, 'MTH202', 'Analyse des données', 4),
(16, 'MTH203', 'MAO', 4),
(17, 'MTH204', 'Géométrie', 4),
(18, 'MTH205', 'Equations différentielles', 4),
(19, 'MTH206', 'Optimisation', 4);

-- =========================
-- SEMESTRE 3 (COMMUN)
-- =========================
INSERT INTO programme VALUES
(1, 1, 1, 1, NULL),
(2, 1, 1, 2, NULL),
(3, 1, 1, 3, NULL),
(4, 1, 1, 4, NULL),
(5, 1, 1, 5, NULL),
(6, 1, 1, 6, NULL);

-- =========================
-- GROUPES S4 - DEV
-- =========================
INSERT INTO groupe_ue VALUES
(1, 'DEV - Choix Info (6 crédits)', 1),
(2, 'DEV - Choix Math (4 crédits)', 1);

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
(33, 1, 2, 16, NULL); -- MAO obligatoire

-- =========================
-- GROUPES S4 - BD/RÉSEAUX
-- =========================
INSERT INTO groupe_ue VALUES
(3, 'BDR - Choix Info (6 crédits)', 1),
(4, 'BDR - Choix Math (4 crédits)', 1);

INSERT INTO groupe_ue_element VALUES
(9, 3, 7),
(10, 3, 9),
(11, 3, 10),

(12, 4, 15),
(13, 4, 18),
(14, 4, 19);

-- =========================
-- PROGRAMME BDR S4
-- =========================
INSERT INTO programme VALUES
(20, 2, 2, 8, NULL),
(21, 2, 2, NULL, 3),
(22, 2, 2, 13, NULL),
(23, 2, 2, NULL, 4),
(34, 2, 2, 16, NULL); -- MAO obligatoire

-- =========================
-- GROUPES S4 - WEB & DESIGN
-- =========================
INSERT INTO groupe_ue VALUES
(5, 'WEB - Choix Info (6 crédits)', 1),
(6, 'WEB - Choix Math (4 crédits)', 1);

INSERT INTO groupe_ue_element VALUES
(16, 5, 7),
(17, 5, 8),
(18, 5, 9),
(19, 5, 11),

(20, 6, 15),
(21, 6, 17),
(22, 6, 19);

-- =========================
-- PROGRAMME WEB S4
-- =========================
INSERT INTO programme VALUES
(30, 3, 2, NULL, 5),
(31, 3, 2, 14, NULL),
(32, 3, 2, NULL, 6),
(35, 3, 2, 16, NULL); -- MAO obligatoire