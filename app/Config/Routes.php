<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'IndexController::index', ['filter' => ['login', 'components']]);
$routes->post('/createVoucher', 'IndexController::createVoucher', ['filter' => ['login', 'components']]);

$routes->get('/logout', 'AuthenticationController::logout');

$routes->get('/admin/vouchers', 'VoucherController::index', ['filter' => ['admin', 'components']]);
$routes->post('/admin/vouchers/create', 'VoucherController::create', ['filter' => ['admin']]);
$routes->get('/admin/vouchers/show', 'VoucherController::show', ['filter' => ['admin']]);
$routes->get('/admin/vouchers/delete', 'VoucherController::delete', ['filter' => ['admin']]);

$routes->get('/admin/students', 'StudentController::index', ['filter' => ['admin', 'components']]);
$routes->post('/admin/students/create', 'StudentController::create', ['filter' => ['admin']]);
$routes->get('/admin/students/delete', 'StudentController::delete', ['filter' => ['admin']]);

$routes->get('/site', 'AuthenticationController::changeSite', ['filter' => ['login']]);