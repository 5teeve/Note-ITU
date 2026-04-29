<?php
$file = 'app/Models/NotesModel.php';
$content = file_get_contents($file);

$method = "
    /**
     * Récupère les notes d'un étudiant pour un semestre donné
     * Utilise LEFT JOIN, les sans notes sont à 0.
     * Pour une matière, on prend la note maximale.
     * Pour les matières optionnelles, on prend la matière qui a la meilleure note.
     */
    public function getNotesEtudiantBySemestre(\$id_etudiant, \$semestre_id)
    {
        \$db = \Config\Database::connect();
        
        \$sql = \"
            SELECT
                u.id as ue_id,
                u.code as code,
                u.libelle as libelle,
                u.credits as credits,
                COALESCE(MAX(n.note), 0) as max_note,
                MAX(n.id) as note_id,
                g_ue.id as groupe_ue_id,
                CAST(g_ue.id as CHAR) as groupe_key,
                g_ue.libelle as groupe_libelle
            FROM ue u
            LEFT JOIN groupe_ue_element gue ON gue.ue_id = u.id
            LEFT JOIN groupe_ue g_ue ON g_ue.id = gue.groupe_ue_id
            JOIN programme p ON p.ue_id = u.id OR p.groupe_ue_id = g_ue.id
            JOIN semestre s ON p.semestre_id = s.id AND s.id = ?
            LEFT JOIN note n ON n.ue_id = u.id AND n.id_etudiant = ? AND n.semestre_id = s.id
            GROUP BY u.id, u.code, u.libelle, u.credits, g_ue.id, g_ue.libelle
        \";
        
        \$results = \$db->query(\$sql, [\$semestre_id, \$id_etudiant])->getResultArray();
        
        \$groupes_max = [];
        foreach (\$results as \$row) {
            \$gk = \$row['groupe_key'];
            if (\$gk) {
                if (!isset(\$groupes_max[\$gk]) || \$row['max_note'] > \$groupes_max[\$gk]['max_note']) {
                    \$groupes_max[\$gk] = \$row;
                }
            }
        }
        
        \$final_results = [];
        foreach (\$results as \$row) {
            \$gk = \$row['groupe_key'];
            if (\$gk) {
                if (\$groupes_max[\$gk]['ue_id'] == \$row['ue_id']) {
                    \$final_results[\$row['ue_id']] = \$row;
                }
            } else {
                \$final_results[\$row['ue_id']] = \$row;
            }
        }
        
        return array_values(\$final_results);
    }
";
if (strpos($content, "getNotesEtudiantBySemestre") === false) {
    $content = preg_replace('/\}\s*$/', "\n" . $method . "\n}", $content);
    file_put_contents($file, $content);
}
