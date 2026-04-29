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
}
