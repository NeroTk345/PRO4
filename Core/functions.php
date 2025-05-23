<?php

//function dat er voor zorgt dat je weet wat voor een informatie wordt gedumpt.

require_once 'Response.php';
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

//Een function dat weet door URI welke pagina hij staat, en de style veranderd in (views/partials/nav.php)
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Core\Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require_once base_path('views/' . $path);
}

function login($user)
{
    var_dump($user); // Debugging to check if 'id' is passed to the login function
    $_SESSION['user'] = [
        'id' => $user['id'],
        'email' => $user['email']
    ];

    session_regenerate_id(true);
}