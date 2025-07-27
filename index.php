<?php

// No longer need session_start() here directly, controllers will manage it
// No more login processing logic here

require_once __DIR__ . '/src/Router.php';
require_once __DIR__ . '/src/Config.php';

// Include controllers (or use an autoloader if you set one up with Composer)
require_once __DIR__ . '/src/Controllers/AuthController.php';
require_once __DIR__ . '/src/Controllers/DashboardController.php';

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;

// Initialize Router
$router = new Router();

// Define Routes
// GET request for the login form
$router->addRoute('GET', '/', ['AuthController', 'showLogin']);
// POST request for submitting login form
$router->addRoute('POST', '/', ['AuthController', 'handleLogin']);

// GET request for the signup form
$router->addRoute('GET', '/signup', ['AuthController', 'showSignup']);
// POST request for submitting signup form
$router->addRoute('POST', '/signup', ['AuthController', 'handleSignup']);

// GET request for the dashboard page
$router->addRoute('GET', '/dashboard', ['DashboardController', 'index']);

// GET request for logout
$router->addRoute('GET', '/logout', ['AuthController', 'handleLogout']);

// Dispatch the request
$router->dispatch();
