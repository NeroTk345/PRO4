<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

// Controleer of gebruiker beheerder is
$currentUserId = $_SESSION['user']['id'] ?? null;
$userRole = $_SESSION['user']['role'] ?? null;

if (!$currentUserId) {
    header('Location: /login');
    exit();
}

if ($userRole !== 'Beheerder' && $userRole !== 'Admin') {
    header('Location: /');
    exit();
}

// Haal alle voorstellingen op
$voorstellingen = $db->query('
    SELECT 
        id, titel, beschrijving, datum, tijd, prijs, 
        max_bezoekers, huidige_bezoekers, locatie, 
        afbeelding_url, status, aangemaakt_op
    FROM voorstellingen 
    ORDER BY datum ASC, tijd ASC
')->get();

view("admin/shows/index.view.php", [
    'heading' => 'Voorstellingen Beheren',
    'voorstellingen' => $voorstellingen
]);