<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);


$routes->add('/register', 'Users::signup');
$routes->post('/login', 'Users::signin');
$routes->post('/token_login', 'Users::get_session_by_token');
$routes->resource('users', ['filter' => 'role:admin']);
$routes->group('quiz', function ($routes) {
    $routes->resource('/', [ 'controller' => 'quiz' ]);
    $routes->resource('categories');
    $routes->resource('question');
    $routes->resource('answer');
});


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
