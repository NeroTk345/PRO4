<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Controleer beheerders toegang
$currentUserId = $_SESSION['user']['id'] ?? null;
$userRole = $_SESSION['user']['role'] ?? null;

if (!$currentUserId || ($userRole !== 'Beheerder' && $userRole !== 'Admin')) {
    header('Location: /');
    exit();
}

$voorstelling = $db->query('SELECT * FROM voorstellingen WHERE id = :id', [
    'id' => $_GET['id']
])->findOrFail();

view("admin/shows/edit.view.php", [
    'heading' => 'Voorstelling Bewerken',
    'voorstelling' => $voorstelling,
    'errors' => []
]);