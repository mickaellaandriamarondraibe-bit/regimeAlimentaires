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
$routes->get('/profil', 'UserController::profil');
$routes->post('/profil/update', 'UserController::modifierProfil');

$routes->get('code', 'codeController::code');
$routes->post('envoyerCode', 'codeController::validationCode');

$routes->get('/ingredient', 'IngredientController::listAll');

$routes->get('/regime/create', 'RegimeController::showForm');
$routes->post('/regime/create', 'RegimeController::saveRegime');
$routes->get('/regime/list', 'RegimeController::list');
$routes->get('/regime/detail/(:num)', 'RegimeController::detail/$1');
$routes->post('/ingredient/create', 'IngredientController::create');

$routes->get('/sport', 'SportController::listSport');
$routes->get('/sport/create', 'SportController::edit');
$routes->post('/sport/create', 'SportController::saveSport');
$routes->get('/sport/edit/(:num)', 'SportController::edit/$1');
$routes->post('/sport/update/(:num', 'SportController::update/$1');
$routes->post('/sport/delete/(:num)', 'SportController::delete/$1');
$routes->get('/sport/detail/(:num)', 'SportController::detail/$1');
$routes->get('/sport/(:num)/regimes', 'SportController::regimesAssocies/$1');
$routes->post('/sport/(:num)/regimes/save', 'SportController::saveRegime/$1');