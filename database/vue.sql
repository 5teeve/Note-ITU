CREATE VIEW v_note_max AS
SELECT 
    n.id_etudiant,
    n.semestre_id,
    n.ue_id,
    MAX(n.note) AS note
FROM note n
GROUP BY n.id_etudiant, n.semestre_id, n.ue_id;


CREATE VIEW v_programme_ue AS
-- UE directes
SELECT 
    p.id AS programme_id,
    p.parcours_id,
    p.semestre_id,
    u.id AS ue_id,
    u.code,
    u.libelle,
    u.credits,
    NULL AS groupe_ue_id
FROM programme p
JOIN ue u ON u.id = p.ue_id

UNION ALL

-- UE provenant des groupes
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
JOIN groupe_ue_element gue ON gue.groupe_ue_id = p.groupe_ue_id
JOIN ue u ON u.id = gue.ue_id;

CREATE VIEW v_notes_jointes AS
SELECT 
    pu.*,
    nm.id_etudiant,
    COALESCE(nm.note, 0) AS note
FROM v_programme_ue pu
LEFT JOIN v_note_max nm 
    ON nm.ue_id = pu.ue_id 
    AND nm.semestre_id = pu.semestre_id;


CREATE VIEW v_classement_groupe AS
SELECT 
    nj.*,
    ROW_NUMBER() OVER (
        PARTITION BY id_etudiant, groupe_ue_id
        ORDER BY note DESC
    ) AS rang
FROM v_notes_jointes nj;


CREATE VIEW v_releve_notes AS
SELECT 
    id_etudiant,
    semestre_id,
    ue_id,
    code,
    libelle,
    credits,
    note
FROM v_classement_groupe
WHERE 
    groupe_ue_id IS NULL
    OR rang = 1;