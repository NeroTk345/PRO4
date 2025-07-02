<?php
$config = require __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Core/Database.php';
use Core\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database($config['database']);
    // Verzamel en valideer de input
    $voornaam = $_POST['Voornaam'] ?? '';
    $tussenvoegsel = $_POST['Tussenvoegsel'] ?? '';
    $achternaam = $_POST['Achternaam'] ?? '';
    $gebruikersnaam = $_POST['Gebruikersnaam'] ?? '';
    $wachtwoord = $_POST['Wachtwoord'] ?? '';
    $rolId = $_POST['RolId'] ?? null;

    if ($voornaam && $achternaam && $gebruikersnaam && $wachtwoord && $rolId) {
        // Voeg gebruiker toe
        $db->query('INSERT INTO gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd) VALUES (?, ?, ?, ?, ?, 0, 1, NOW(), NOW())', [
            $voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, password_hash($wachtwoord, PASSWORD_DEFAULT)
        ]);
        $gebruikerId = $db->connection->lastInsertId();
        // Haal de rolnaam op
        $rol = $db->query('SELECT Naam FROM rol WHERE Id = ?', [$rolId])->find();
        $rolnaam = $rol ? $rol['Naam'] : '';
        // Voeg rol toe
        $db->query('INSERT INTO rol (GebruikerId, Naam, Isactief, Datumaangemaakt, Datumgewijzigd) VALUES (?, ?, 1, NOW(), NOW())', [
            $gebruikerId, $rolnaam
        ]);
    }
}
header('Location: /admin/members');
exit;
