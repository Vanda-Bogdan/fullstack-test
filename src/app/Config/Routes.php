<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --------------------- Auth --------------------------------
$routes->get('login', 'AuthController::showLogin');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::showRegister');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// --------------------- Comment --------------------------------
$routes->get('/', 'CommentsController::index');
$routes->post('comments', 'CommentsController::store');
$routes->post('commentsAjax', 'CommentsController::storeAjax');
$routes->post('comments/(:num)/delete', 'CommentsController::deleteAjax/$1');
$routes->get('comments/list', 'CommentsController::listAjax');