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

$routes->get('/code', 'CodeController::code');
$routes->post('/envoyerCode', 'CodeController::validationCode');

$routes->get('/test', 'InfoClientController::test');
$routes->post('/achat', 'InfoClientController::validationDepense');

