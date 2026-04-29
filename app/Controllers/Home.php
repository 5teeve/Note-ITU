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
        return view('form');
    }

    public function login(): string
    {
        return view('login');
    }
}
