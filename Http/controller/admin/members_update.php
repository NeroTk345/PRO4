<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$id = $_POST['Id'];
$voornaam = $_POST['Voornaam'];
$tussenvoegsel = $_POST['Tussenvoegsel'];
$achternaam = $_POST['Achternaam'];
$gebruikersnaam = $_POST['Gebruikersnaam'];
$rolId = $_POST['RolId'];

if (empty($id) || empty($voornaam) || empty($achternaam) || empty($gebruikersnaam) || empty($rolId)) {
    // Redirect if essential data is missing
    header('Location: /admin/members');
    exit();
}

// 1. Update user details in the 'gebruiker' table
$db->query(
    'UPDATE gebruiker SET Voornaam = :voornaam, Tussenvoegsel = :tussenvoegsel, Achternaam = :achternaam, Gebruikersnaam = :gebruikersnaam WHERE Id = :id',
    [
        'id' => $id,
        'voornaam' => $voornaam,
        'tussenvoegsel' => $tussenvoegsel,
        'achternaam' => $achternaam,
        'gebruikersnaam' => $gebruikersnaam,
    ]
);

// 2. Map RolId to role name and update/insert the 'rol' table
$rolMap = [
    '1' => 'Admin',
    '2' => 'Medewerker',
    '3' => 'Bezoeker'
];
$rolNaam = $rolMap[$rolId] ?? null;

if ($rolNaam) {
    // Check if a role entry already exists for the user
        $existingRole = $db->query('SELECT GebruikerId FROM rol WHERE GebruikerId = :id', ['id' => $id])->find();

    if ($existingRole) {
        // If it exists, update it and set the modification date
        $db->query(
            'UPDATE rol SET Naam = :rolnaam, Datumgewijzigd = NOW() WHERE GebruikerId = :id',
            ['id' => $id, 'rolnaam' => $rolNaam]
        );
    } else {
        // If it does not exist, insert a new one, setting it as active and adding creation/modification dates
        $db->query(
            'INSERT INTO rol(Naam, GebruikerId, Isactief, Datumaangemaakt, Datumgewijzigd) VALUES(:rolnaam, :id, 1, NOW(), NOW())',
            ['id' => $id, 'rolnaam' => $rolNaam]
        );
    }
}

header('Location: /admin/members');
exit();

