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
$routes->get('/notes/new', 'Notes::new');
$routes->get('/notes/create', 'Notes::new');
$routes->post('/notes/create', 'Notes::create');
