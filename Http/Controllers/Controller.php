<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function view($path, $data = [])
    {
        extract($data);
        require base_path('views/' . $path . '.php');
    }
    
    protected function redirect($path)
    {
        header("Location: {$path}");
        exit();
    }
    
    protected function currentUser()
    {
        return $_SESSION['user'] ?? null;
    }
    
    protected function currentUserId()
    {
        return $_SESSION['user']['id'] ?? null;
    }
}