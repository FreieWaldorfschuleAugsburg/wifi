<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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