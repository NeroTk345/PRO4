<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

const BASE_PATH = __DIR__ . '/../';

require_once BASE_PATH . 'Core/functions.php';

spl_autoload_register(function ($class) {
    // Debug: Show what class is being loaded
    // echo "Trying to load: " . $class . "<br>";
    
    // Convert namespace separators to directory separators
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // Define possible file paths
    $paths = [
        BASE_PATH . $class . '.php',
        BASE_PATH . str_replace('App' . DIRECTORY_SEPARATOR, '', $class) . '.php',
    ];
    
    // Debug: Show paths being checked
    // echo "Checking paths: <pre>" . print_r($paths, true) . "</pre>";
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            // echo "Found at: " . $path . "<br>";
            require $path;
            return;
        }
    }
    
    // Debug: If not found
    // echo "Class not found: " . $class . "<br>";
});

session_start();

require_once base_path('bootstrap.php');

$router = new \Core\Router();
$routes = require_once base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (Exception $e) {
    // Handle errors
    echo "<h1>Error:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}