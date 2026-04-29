<?php

namespace App\Models;

use CodeIgniter\Model;

class NotesModel extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['note', 'ue_id', 'id_etudiant', 'semestre_id'];
    protected $useTimestamps = false;
    protected $validationRules = [
        'ute' => 'required|string|max_length[50]',
        'semestre' => 'required|string',
        'ue' => 'required|string',
        'note' => 'permit_empty|numeric|greater_than_equal_to[0]|less_than_equal_to[20]',
    ];

    /**
     * Récupère un étudiant par son numéro
     */
    public function getEtudiantByNumero($numero)
    {
        $db = \Config\Database::connect();
        return $db->table('etudiant')
            ->where('numero_etu', $numero)
            ->get()
            ->getRowArray();
    }

    /**
     * Récupère une UE par son libellé
     */
    public function getUEByLibelle($libelle)
    {
        $db = \Config\Database::connect();
        return $db->table('ue')
            ->where('libelle', $libelle)
            ->get()
            ->getRowArray();
    }

    /**
     * Récupère un semestre par son numéro
     */
    public function getSemestreByNumero($numero)
    {
        $db = \Config\Database::connect();
        return $db->table('semestre')
            ->where('numero', $numero)
            ->get()
            ->getRowArray();
    }

    /**
     * Enregistre une note avec les informations fournies
     */
    public function saveNote($data)
    {
        // Récupérer les IDs à partir des données
        $etudiant = $this->getEtudiantByNumero($data['etu']);
        if (!$etudiant) {
            return ['success' => false, 'message' => 'Étudiant non trouvé'];
        }

        $semestre = $this->getSemestreByNumero((int)substr($data['semestre'], 1));
        if (!$semestre) {
            return ['success' => false, 'message' => 'Semestre non trouvé'];
        }

        $ue = $this->getUEByLibelle($data['ue']);
        if (!$ue) {
            return ['success' => false, 'message' => 'UE non trouvée'];
        }

        // Préparer les données pour l'insertion
        $noteData = [
            'note' => $data['note'] ?? 0,
            'ue_id' => $ue['id'],
            'id_etudiant' => $etudiant['id'],
            'semestre_id' => $semestre['id'],
        ];

        // Vérifier s'il existe déjà une note pour cet étudiant, ce semestre et cette UE
        $existingNote = $this->where('id_etudiant', $etudiant['id'])
            ->where('semestre_id', $semestre['id'])
            ->where('ue_id', $ue['id'])
            ->first();

        if ($existingNote) {
            // Mettre à jour la note existante
            $this->update($existingNote['id'], $noteData);
            return ['success' => true, 'message' => 'Note mise à jour avec succès', 'id' => $existingNote['id']];
        } else {
            // Insérer une nouvelle note
            $result = $this->insert($noteData);
            return ['success' => true, 'message' => 'Note enregistrée avec succès', 'id' => $this->insertID];
        }
    }

    /**
     * Récupère toutes les notes
     */
    public function getAllNotes()
    {
        $db = \Config\Database::connect();
        return $db->table('note')
            ->select('note.id, note.note, ue.libelle as ue, semestre.numero as semestre, etudiant.numero_etu, etudiant.nom, etudiant.prenom')
            ->join('ue', 'note.ue_id = ue.id')
            ->join('semestre', 'note.semestre_id = semestre.id')
            ->join('etudiant', 'note.id_etudiant = etudiant.id')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère toutes les UE
     */
    public function getAllUE()
    {
        $db = \Config\Database::connect();
        return $db->table('ue')
            ->orderBy('libelle', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les UE pour un semestre donné
     */
    public function getUEBySemestre($semestNumber)
    {
        $db = \Config\Database::connect();
        
        // Récupérer les UE directes du semestre
        $directUEs = $db->query(
            "SELECT DISTINCT ue.id, ue.code, ue.libelle, ue.credits FROM ue JOIN programme ON ue.id = programme.ue_id JOIN semestre ON programme.semestre_id = semestre.id WHERE semestre.numero = ? AND programme.ue_id IS NOT NULL ORDER BY ue.libelle ASC",
            [$semestNumber]
        )->getResultArray();

        // Récupérer les UE via les groupes d'UE du semestre
        $groupUEs = $db->query(
            "SELECT DISTINCT ue.id, ue.code, ue.libelle, ue.credits FROM ue JOIN groupe_ue_element ON ue.id = groupe_ue_element.ue_id JOIN groupe_ue ON groupe_ue_element.groupe_ue_id = groupe_ue.id JOIN programme ON groupe_ue.id = programme.groupe_ue_id JOIN semestre ON programme.semestre_id = semestre.id WHERE semestre.numero = ? ORDER BY ue.libelle ASC",
            [$semestNumber]
        )->getResultArray();

        // Fusionner et dédupliquer
        $allUEs = array_merge($directUEs, $groupUEs);
        $uniqueUEs = [];
        $seen = [];
        
        foreach ($allUEs as $ue) {
            if (!isset($seen[$ue['id']])) {
                $seen[$ue['id']] = true;
                $uniqueUEs[] = $ue;
            }
        }

        return $uniqueUEs;
    }


    /**
     * Récupère les notes d'un étudiant pour un semestre donné
     * Utilise LEFT JOIN, les sans notes sont à 0.
     * Pour une matière, on prend la note maximale.
     * Pour les matières optionnelles, on prend la matière qui a la meilleure note.
     */
    public function getNotesEtudiantBySemestre($id_etudiant, $semestre_id)
    {
        $db = \Config\Database::connect();
        
        $sql = "
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
        ";
        
        $results = $db->query($sql, [$semestre_id, $id_etudiant])->getResultArray();
        
        $groupes_max = [];
        foreach ($results as $row) {
            $gk = $row['groupe_key'];
            if ($gk) {
                if (!isset($groupes_max[$gk]) || $row['max_note'] > $groupes_max[$gk]['max_note']) {
                    $groupes_max[$gk] = $row;
                }
            }
        }
        
        $final_results = [];
        foreach ($results as $row) {
            $gk = $row['groupe_key'];
            if ($gk) {
                if ($groupes_max[$gk]['ue_id'] == $row['ue_id']) {
                    $final_results[$row['ue_id']] = $row;
                }
            } else {
                $final_results[$row['ue_id']] = $row;
            }
        }
        
        return array_values($final_results);
    }

}