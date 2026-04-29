<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login'); // default to login
    }

    public function dashboard(): string
    {
        return view('dashboard');
    }

    public function list(): string
    {
        return view('list');
    }

    public function form(): string
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

    public function login(): string
    {
        return view('login');
    }
}
