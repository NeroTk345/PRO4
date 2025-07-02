<?php
$config = require __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Core/Database.php';
use Core\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Id'])) {
    $db = new Database($config['database']);
    $id = $_POST['Id'];
    $naam = $_POST['Naam'] ?? '';
    $beschrijving = $_POST['Beschrijving'] ?? '';
    $datum = $_POST['Datum'] ?? '';
    $tijd = $_POST['Tijd'] ?? '';
    $locatie = $_POST['Locatie'] ?? '';
    $maxAantalTickets = $_POST['MaxAantalTickets'] ?? 0;
    $beschikbaarheid = $_POST['Beschikbaarheid'] ?? 'Beschikbaar';
    $opmerking = $_POST['Opmerking'] ?? '';

    $db->query('UPDATE voorstelling SET Naam = ?, Beschrijving = ?, Datum = ?, Tijd = ?, Locatie = ?, MaxAantalTickets = ?, Beschikbaarheid = ?, Opmerking = ? WHERE Id = ?', [
        $naam, $beschrijving, $datum, $tijd, $locatie, $maxAantalTickets, $beschikbaarheid, $opmerking, $id
    ]);
}
header('Location: /shows');
exit;
