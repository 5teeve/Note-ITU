<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->get('/dashboard', 'Home::dashboard');
$routes->get('/list', 'Home::list');
$routes->get('/form', 'Home::form');

$routes->get('/etudiants', 'EtudiantController::index');

// Notes
$routes->get('/notes/etudiant/(:num)', 'EtudiantController::details/$1');
$routes->post('/notes/edit/(:num)', 'EtudiantController::editNote/$1');
$routes->get('/notes/delete/(:num)', 'EtudiantController::deleteNote/$1');

