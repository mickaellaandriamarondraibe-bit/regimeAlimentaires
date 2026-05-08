<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'UserController::login');

$routes->get('/inscription', 'UserController::inscriptionPage1');
$routes->post('/step2', 'UserController::inscriptionPage2');

$routes->get('/step2', 'UserController::inscriptionPage2');
$routes->post('/savePage2', 'UserController::savePage2');   

$routes->post('/register', 'UserController::enregistrementUser');

$routes->get('/logout', 'UserController::logout');
$routes->post('/validationLogin','UserController::validationLogin');

$routes->get('/acceuil', 'UserController::acceuil');

$routes->get('/ingredient', 'IngredientController::listAll');

$routes->get('/regime/create', 'RegimeController::showForm');
$routes->post('/regime/create', 'RegimeController::saveRegime');
$routes->get('/regime/list', 'RegimeController::list');
