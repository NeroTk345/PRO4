<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userId = $_SESSION['user']['id'] ?? null;
$userRole = $_SESSION['user']['role'] ?? null;
$notes = [];
if ($userRole === 'Admin') {
    $notes = $db->query('SELECT m.*, v.naam as voorstelling_naam, g.Gebruikersnaam as gebruiker_naam FROM melding m LEFT JOIN voorstelling v ON m.voorstelling = v.id LEFT JOIN Gebruiker g ON m.GebruikerId = g.id')->get();
} elseif ($userId) {
    $notes = $db->query('SELECT m.*, v.naam as voorstelling_naam, g.Gebruikersnaam as gebruiker_naam FROM melding m LEFT JOIN voorstelling v ON m.voorstelling = v.id LEFT JOIN Gebruiker g ON m.GebruikerId = g.id WHERE m.GebruikerId = :userId', [
        'userId' => $userId
    ])->get();
}

// Haal alle reacties op
$reacties = $db->query('SELECT r.*, g.Gebruikersnaam FROM reactie r LEFT JOIN gebruiker g ON r.gebruiker_id = g.id')->get();

view("notes/index.view.php", [
    'heading' => 'My notes',
    'notes' => $notes,
    'reacties' => $reacties
]);
