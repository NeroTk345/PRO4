<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

const BASE_PATH = __DIR__ . '/../';

// Test 1: Basic PHP
echo "PHP is working<br>";

// Test 2: Autoloader
require_once BASE_PATH . 'Core/functions.php';
echo "Functions loaded<br>";

// Test 3: Check if directories exist
echo "App directory exists: " . (is_dir(BASE_PATH . 'App') ? 'YES' : 'NO') . "<br>";
echo "App/Http/Controllers exists: " . (is_dir(BASE_PATH . 'App/Http/Controllers') ? 'YES' : 'NO') . "<br>";

// Test 4: Check Router
if (class_exists('\Core\Router')) {
    echo "Router class found<br>";
} else {
    echo "Router class NOT found<br>";
}

// Test 5: Check if HomeController exists
$controllerPath = BASE_PATH . 'App/Http/Controllers/HomeController.php';
echo "HomeController file exists: " . (file_exists($controllerPath) ? 'YES' : 'NO') . "<br>";

// Test 6: Try to load HomeController
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    if (class_exists('App\Http\Controllers\HomeController')) {
        echo "HomeController class loaded successfully<br>";
    } else {
        echo "HomeController class NOT loaded<br>";
    }
}