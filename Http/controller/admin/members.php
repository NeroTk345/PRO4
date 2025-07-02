<?php

use Core\App;
use Core\Database;

if (!isset($_SESSION['user']) || strtolower($_SESSION['user']['role']) !== 'admin') {
    http_response_code(403);
    echo 'Toegang geweigerd.';
    exit;
}

$db = App::resolve(Database::class);

$leden = $db->query(
    "SELECT g.Id, g.Voornaam, g.Tussenvoegsel, g.Achternaam, g.Gebruikersnaam, r.Naam AS rolnaam, 
            CASE r.Naam 
                WHEN 'Admin' THEN 1 
                WHEN 'Medewerker' THEN 2 
                WHEN 'Bezoeker' THEN 3 
                ELSE NULL 
            END AS RolId
     FROM gebruiker g 
     LEFT JOIN rol r ON r.GebruikerId = g.Id"
)->get();

view('admin/members.view.php', [
    'leden' => $leden,
]);

