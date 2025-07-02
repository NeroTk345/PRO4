<?php

// Alleen admins mogen toevoegen
if (!isset($_SESSION['user']['role']) || strtolower($_SESSION['user']['role']) !== 'admin') {
    http_response_code(403);
    die('Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $config = require base_path('config.php');
    $db = new \Core\Database($config['database'], $config['database']['username'], $config['database']['password']);

    // Validatie en ophalen van POST-data
    $naam = $_POST['Naam'] ?? '';
    $beschrijving = $_POST['Beschrijving'] ?? '';
    $datum = $_POST['Datum'] ?? '';
    $tijd = $_POST['Tijd'] ?? '';
    $locatie = $_POST['Locatie'] ?? '';
    $maxAantalTickets = $_POST['MaxAantalTickets'] ?? 0;
    $beschikbaarheid = $_POST['Beschikbaarheid'] ?? 'Beschikbaar';
    $opmerking = $_POST['Opmerking'] ?? null;
    $medewerkerId = $_SESSION['user']['id'] ?? 1;
    $isactief = 1;
    $now = date('Y-m-d H:i:s');

    // Insert query
    $db->query('INSERT INTO voorstelling (MedewerkerId, Naam, Beschrijving, Datum, Tijd, Locatie, MaxAantalTickets, Beschikbaarheid, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        $medewerkerId,
        $naam,
        $beschrijving,
        $datum,
        $tijd,
        $locatie,
        $maxAantalTickets,
        $beschikbaarheid,
        $isactief,
        $opmerking,
        $now,
        $now
    ]);

    // Redirect terug naar shows overzicht
    header('Location: /shows');
    exit;
}

// Geen POST: redirect naar shows
header('Location: /shows');
exit;
