<?php

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {

    $classPath = str_replace('\\', '/', $class);

    // dd($_SERVER);
    require base_path($classPath . '.php');
});

session_start();

require_once base_path('bootstrap.php');

$router = new \Core\Router();
$routes = require_once base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);

