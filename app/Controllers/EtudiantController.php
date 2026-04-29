<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NotesModel;

class EtudiantController extends BaseController
{
    public function index()
    {
        $model = new EtudiantModel();
        
        $data = [
            'titre'     => 'Liste des étudiants',
            'etudiants' => $model->getEtudiants()
        ];
        
        return view('etudiants', $data);
    }

    public function details($id)
    {
        $etudiantModel = new EtudiantModel();
        $noteModel = new NotesModel();
        
        $etudiant = $etudiantModel->find($id);
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Filtrage par semestre (1 => S3, 2 => S4)
        $semestre_id = $this->request->getGet('semestre') ?: 1; 
        
        // Récupérer les notes formatées selon la logique métier
        $notes = $noteModel->getNotesEtudiantBySemestre($id, $semestre_id);
        
        // Trier par code UE
        usort($notes, function($a, $b) {
            return strcmp($a['code'], $b['code']);
        });
        
        $data = [
            'etudiant' => $etudiant,
            'notes' => $notes,
            'current_semestre' => $semestre_id
        ];
        
        return view('etudiant_details', $data);
    }

    public function editNote($id)
    {
        $noteModel = new NotesModel();
        $nouvelle_note = $this->request->getPost('note');
        
        if ($nouvelle_note !== null) {
            $noteModel->update($id, ['note' => $nouvelle_note]);
        }
        
        return redirect()->back();
    }

    public function deleteNote($id)
    {
        $noteModel = new NotesModel();
        $noteModel->delete($id);
        
        return redirect()->back();
    }

    public function upsertNote()
    {
        $noteModel = new NotesModel();
        
        $id_etudiant = $this->request->getPost('id_etudiant');
        $ue_id = $this->request->getPost('ue_id');
        $semestre_id = $this->request->getPost('semestre_id');
        $nouvelle_note = $this->request->getPost('note');
        
        if ($nouvelle_note !== null && $id_etudiant && $ue_id && $semestre_id) {
            // Vérifier s'il existe déjà une note pour cet étudiant/UE/semestre
            $existing_note = $noteModel->where('id_etudiant', $id_etudiant)
                                       ->where('ue_id', $ue_id)
                                       ->where('semestre_id', $semestre_id)
                                       ->first();
            
            if ($existing_note) {
                // Mettre à jour
                $noteModel->update($existing_note['id'], ['note' => $nouvelle_note]);
            } else {
                // Insérer
                $noteModel->insert([
                    'id_etudiant' => $id_etudiant,
                    'ue_id' => $ue_id,
                    'semestre_id' => $semestre_id,
                    'note' => $nouvelle_note
                ]);
            }
        }
        
        return redirect()->back();
    }
}
