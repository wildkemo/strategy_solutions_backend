<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

// Initialize router
$router = new Router();

// Define routes
$router->add('GET', '/', 'App\Controllers\HomeController', 'index');
$router->add('POST', '/login', 'App\Controllers\AuthController', 'login');
$router->add('POST', '/register', 'App\Controllers\AuthController', 'register');
$router->add('GET', '/logout', 'App\Controllers\AuthController', 'logout');

// Dispatch the request
$router->dispatch(); 