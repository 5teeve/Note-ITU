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
        $directUEs = $db->table('ue')
            ->join('programme', 'ue.id = programme.ue_id')
            ->join('semestre', 'programme.semestre_id = semestre.id')
            ->where('semestre.numero', $semestNumber)
            ->where('programme.ue_id IS NOT NULL')
            ->select('DISTINCT ue.id, ue.code, ue.libelle, ue.credits')
            ->get()
            ->getResultArray();

        // Récupérer les UE via les groupes d'UE du semestre
        $groupUEs = $db->table('ue')
            ->join('groupe_ue_element', 'ue.id = groupe_ue_element.ue_id')
            ->join('groupe_ue', 'groupe_ue_element.groupe_ue_id = groupe_ue.id')
            ->join('programme', 'groupe_ue.id = programme.groupe_ue_id')
            ->join('semestre', 'programme.semestre_id = semestre.id')
            ->where('semestre.numero', $semestNumber)
            ->select('DISTINCT ue.id, ue.code, ue.libelle, ue.credits')
            ->get()
            ->getResultArray();

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

        // Trier par libellé
        usort($uniqueUEs, function($a, $b) {
            return strcmp($a['libelle'], $b['libelle']);
        });

        return $uniqueUEs;
    }
}
