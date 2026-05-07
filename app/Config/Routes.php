<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/ingredient', 'IngredientController::listAll');
$routes->get('/regime/create', 'RegimeController::showForm');
$routes->post('/regime/create', 'RegimeController::saveRegime');
