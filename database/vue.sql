CREATE OR REPLACE VIEW v_note_max AS
SELECT 
    n.id_etudiant,
    n.semestre_id,
    n.ue_id,
    MAX(n.note) AS note
FROM note n
GROUP BY n.id_etudiant, n.semestre_id, n.ue_id;


CREATE OR REPLACE VIEW v_programme_ue AS

SELECT 
    p.id AS programme_id,
    p.parcours_id,
    p.semestre_id,
    u.id AS ue_id,
    u.code,
    u.libelle,
    u.credits,
    p.groupe_ue_id
FROM programme p
JOIN ue u ON u.id = p.ue_id

UNION

SELECT 
    p.id,
    p.parcours_id,
    p.semestre_id,
    u.id,
    u.code,
    u.libelle,
    u.credits,
    p.groupe_ue_id
FROM programme p
JOIN groupe_ue_element g ON g.groupe_ue_id = p.groupe_ue_id
JOIN ue u ON u.id = g.ue_id;


CREATE OR REPLACE VIEW v_notes_jointes AS
SELECT 
    e.id AS id_etudiant,
    pu.parcours_id,
    pu.semestre_id,
    pu.ue_id,
    pu.code,
    pu.libelle,
    pu.credits,
    pu.groupe_ue_id,
    COALESCE(nm.note, 0) AS note
FROM etudiant e

-- ❌ PAS de ON 1=1 abusif
JOIN v_programme_ue pu

LEFT JOIN v_note_max nm 
    ON nm.ue_id = pu.ue_id
    AND nm.semestre_id = pu.semestre_id
    AND nm.id_etudiant = e.id;


    CREATE OR REPLACE VIEW v_classement_groupe AS
SELECT 
    nj.*,
    CASE 
        WHEN groupe_ue_id IS NOT NULL THEN
            ROW_NUMBER() OVER (
                PARTITION BY id_etudiant, semestre_id, groupe_ue_id
                ORDER BY note DESC, ue_id ASC
            )
        ELSE 1
    END AS rang
FROM v_notes_jointes nj;

CREATE OR REPLACE VIEW v_releve_notes AS
SELECT 
    id_etudiant,
    parcours_id,
    semestre_id,
    ue_id,
    code,
    libelle,
    credits,
    note
FROM v_classement_groupe
WHERE rang = 1;