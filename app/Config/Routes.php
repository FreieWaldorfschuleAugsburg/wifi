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
$routes->setDefaultController('IndexController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'IndexController::index');
$routes->post('/createVoucher', 'IndexController::createVoucher');

$routes->get('/login', 'AuthenticationController::login');
$routes->post('/login', 'AuthenticationController::handleLogin');
$routes->get('/logout', 'AuthenticationController::logout');

$routes->get('/admin/vouchers', 'VoucherController::index');
$routes->post('/admin/vouchers/create', 'VoucherController::create');
$routes->get('/admin/vouchers/delete', 'VoucherController::delete');

$routes->get('/admin/students', 'StudentController::index');
$routes->post('/admin/students/create', 'StudentController::create');
$routes->get('/admin/students/delete', 'StudentController::delete');
$routes->get('/admin/students/print', 'StudentController::print');

$routes->get('/cron', 'StudentController::cron');
$routes->get('/site', 'AuthenticationController::changeSite');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
