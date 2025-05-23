<?php
// Core/Middleware/Admin.php

namespace Core\Middleware;

class Admin
{
    public function handle()
    {
        // Check if user is logged in
        if (!$_SESSION['user'] ?? false) {
            header('location: /login');
            exit();
        }

        // Check if user has admin role
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'Admin') {
            // User is logged in but not an admin - show 403 forbidden
            abort(403);
        }
    }
}