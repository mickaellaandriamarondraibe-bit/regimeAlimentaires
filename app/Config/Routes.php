<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes publiques
$routes->get('/', static fn() => redirect()->to('/login'));
$routes->get('/login', 'UserController::login');
$routes->post('/validationLogin', 'UserController::validationLogin');
$routes->get('/inscription', 'UserController::inscriptionPage1');
$routes->match(['get', 'post'], '/step2', 'UserController::inscriptionPage2');
$routes->post('/savePage2', 'UserController::savePage2');
$routes->post('/register', 'UserController::enregistrementUser');
$routes->get('/programme/catalogue', 'ProgrammeController::catalogue');

// Routes protégées
$routes->group('', ['filter' => 'auth'], static function ($routes): void {
    // Compte utilisateur
    $routes->get('/logout', 'UserController::logout');
    $routes->get('/accueil', 'UserController::accueil');
    $routes->get('/profil', 'UserController::profil');
    $routes->post('/profil/update', 'UserController::modifierProfil');
    $routes->post('/profil/gold', 'UserController::activerGold');

    // Wallet / codes / transactions
    $routes->get('/code', 'CodeController::code');
    $routes->post('/envoyerCode', 'CodeController::validationCode');
    $routes->get('/transactions', 'TransactionController::myTransaction');
    $routes->post('/achat', 'InfoClientController::validationDepense');

    // Programmes
    $routes->get('/programme', 'ProgrammeController::index');
    $routes->post('/programme/suggestion', 'ProgrammeController::suggestion');
    $routes->post('/programme/confirmer', 'ProgrammeController::confirmer');
    $routes->post('/programme/confirmer-catalogue','ProgrammeController::confirmerDepuisCatalogue');
    $routes->get('/programme/mes-programmes','ProgrammeController::mesProgrammes');
    $routes->get('/programme/detail/(:num)','ProgrammeController::detail/$1');

    // Routes admin
    $routes->group('', ['filter' => 'role:admin'], static function ($routes): void {
        // Dashboard
        $routes->get('/dashboard', 'DashboardController::index');

        // Ingrédients
        $routes->get('/ingredient', 'IngredientController::listAll');
        $routes->post('/ingredient/create', 'IngredientController::create');

        // Régimes
        $routes->get('/regime/list', 'RegimeController::list');
        $routes->get('/regime/create', 'RegimeController::showForm');
        $routes->post('/regime/create', 'RegimeController::saveRegime');
        $routes->get('/regime/detail/(:num)','RegimeController::detail/$1');

        // Sports
        $routes->get('/sport', 'SportController::listSport');
        $routes->get('/sport/create', 'SportController::showForm');
        $routes->post('/sport/create', 'SportController::saveSport');
        $routes->get('/sport/edit/(:num)','SportController::edit/$1');
        $routes->post('/sport/update/(:num)','SportController::update/$1');
        $routes->post('/sport/delete/(:num)','SportController::delete/$1');
        $routes->get('/sport/detail/(:num)','SportController::detail/$1');
        $routes->get('/sport/(:num)/regimes','SportController::regimesAssocies/$1');
        $routes->post('/sport/(:num)/regimes/save','SportController::saveRegime/$1');

        // Paramètres
        $routes->get('/parametres', 'ParametreController::index');
        $routes->get('/parametres/create','ParametreController::create');
        $routes->post('/parametres/store','ParametreController::store');
        $routes->get('/parametres/edit/(:num)','ParametreController::edit/$1');
        $routes->post('/parametres/update/(:num)','ParametreController::update/$1');
        $routes->post('/parametres/delete/(:num)','ParametreController::delete/$1');
        // Transactions admin
        $routes->get('/admin/transactions','TransactionController::getAllTransactions');
        // Demandes de codes
        $routes->post('/admin/demandes-code/valider/(:num)','CodeController::validerDemande/$1');
        $routes->post('/admin/demandes-code/refuser/(:num)','CodeController::refuserDemande/$1');
    });
});
