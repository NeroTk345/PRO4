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
    'id' => $_POST['id']
])->findOrFail();

// Verwijder voorstelling
$db->query('DELETE FROM voorstellingen WHERE id = :id', [
    'id' => $_POST['id']
]);

$_SESSION['success_message'] = 'Voorstelling succesvol verwijderd!';
header('Location: /admin/shows');
exit();