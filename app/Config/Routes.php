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
$routes->get('/inscription','UserController::inscription');