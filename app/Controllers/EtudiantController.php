<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EtudiantController extends BaseController
{
    public function index()
    {
        $model = new \App\Models\EtudiantModel();
        
        $data = [
            'etudiants' => $model->getEtudiantsWithParcours()
        ];
        
        return view('etudiants', $data);
    }
}
