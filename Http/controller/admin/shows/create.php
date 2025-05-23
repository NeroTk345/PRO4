<?php

use Core\App;
use Core\Database;

// Controleer beheerders toegang
$currentUserId = $_SESSION['user']['id'] ?? null;
$userRole = $_SESSION['user']['role'] ?? null;

if (!$currentUserId || ($userRole !== 'Beheerder' && $userRole !== 'Admin')) {
    header('Location: /');
    exit();
}

view("admin/shows/create.view.php", [
    'heading' => 'Nieuwe Voorstelling Toevoegen',
    'errors' => []
]);