<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EtudiantController extends BaseController
{
    public function index()
    {
        $model = new \App\Models\EtudiantModel();
        
        $data = [
            'titre'     => 'Liste des étudiants',
            'etudiants' => $model->getEtudiants()
        ];
        
        return view('etudiants', $data);
    }
}
