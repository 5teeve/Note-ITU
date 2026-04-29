<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;

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
        $noteModel = new NoteModel();
        
        $etudiant = $etudiantModel->find($id);
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Default to semester 1 (S3) if none provided
        // Filtrage par semestre
        $semestre_id = $this->request->getGet('semestre') ?: 1; 
        
        // Trier les données si nécessaire
        $notes = $noteModel->getNotesEtudiantBySemestre($id, $semestre_id);
        
        // Let's sort alphabetically by code as a simple sort.
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
        $noteModel = new NoteModel();
        $nouvelle_note = $this->request->getPost('note');
        
        if ($nouvelle_note !== null) {
            $noteModel->update($id, ['note' => $nouvelle_note]);
        }
        
        return redirect()->back();
    }
    
    public function deleteNote($id)
    {
        $noteModel = new NoteModel();
        $noteModel->delete($id);
        
        return redirect()->back();
    }
}
