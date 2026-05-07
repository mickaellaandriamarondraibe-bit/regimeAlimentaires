<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/acceuil', 'Home::index');
$routes->get('/login', 'UserController::login');
$routes->post('/validationLogin', 'UserController::validationLogin');
$routes->get('/logout', 'UserController::logout');
$routes->get('/inscription','UserController::inscriptionPage1');
$routes->get('/step2' , 'UserController::inscriptionPage2');
$routes->post('/savePage2', 'UserController::savePage2');