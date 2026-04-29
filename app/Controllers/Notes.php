<?php

namespace App\Controllers;

use App\Models\NotesModel;

class Notes extends BaseController
{
    /**
     * Affiche le formulaire d'ajout de note
     */
    public function new()
    {
        $model = model('NotesModel');
        $data = [
            'ues' => $model->getAllUE(),
            'uesBySemestre' => [
                'S3' => json_encode($model->getUEBySemestre(3)),
                'S4' => json_encode($model->getUEBySemestre(4)),
            ],
        ];
        return view('form', $data);
    }

    /**
     * Traite la soumission du formulaire et enregistre la note
     */
    public function create()
    {
        $model = model('NotesModel');
        
        // Récupérer les données du formulaire
        $data = [
            'etu' => $this->request->getPost('etu'),
            'semestre' => $this->request->getPost('semestre'),
            'ue' => $this->request->getPost('ue'),
            'note' => $this->request->getPost('note'),
        ];

        // Valider les données
        if (empty($data['etu']) || empty($data['semestre']) || empty($data['ue'])) {
            session()->setFlashdata('error', 'Les champs obligatoires doivent être remplis.');
            return redirect()->back()->withInput();
        }

        // Enregistrer la note
        $result = $model->saveNote($data);

        if ($result['success']) {
            session()->setFlashdata('success', $result['message']);
            return redirect()->to('/form');
        } else {
            session()->setFlashdata('error', $result['message']);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Affiche la liste de toutes les notes
     */
    public function getAllNotes()
    {
        $model = model('NotesModel');
        $notes = $model->getAllNotes();
        return view('list', ['notes' => $notes]);
    }
}
