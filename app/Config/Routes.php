<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'Login::index');
$routes->post('/login', 'Login::index');
// $routes->post('/resetPassword/(:any)/(:any)', 'Login::resetPass/$1/$2');
$routes->post('/resetPassword/(:any)/(:any)', 'Login::resetPass');
$routes->get('/reset-password/(:any)/(:any)', 'Login::forgotPass/$1/$2');
