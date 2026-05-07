<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/login', 'UserController::login');
$routes->post('/login', 'UserController::validationLogin');

$routes->get('/inscription', 'UserController::inscriptionPage1');
$routes->post('/step2', 'UserController::inscriptionPage2');

$routes->get('/step2', 'UserController::inscriptionPage2');
$routes->post('/savePage2', 'UserController::savePage2');   

$routes->post('/register', 'UserController::enregistrementUser');

$routes->get('/logout', 'UserController::logout');
$routes->get('/validationLogin','UserController::validationLogin');