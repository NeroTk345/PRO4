<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch user email from session
$email = $_SESSION['user']['email'] ?? 'Niet beschikbaar';

// Fetch user data from the database
require_once base_path('Core/Database.php');
$config = require base_path('config.php');
use Core\Database;

$db = new Database($config['database'], $config['database']['username'], $config['database']['password']);
$user = $db->query('SELECT Gebruikersnaam, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :gebruikersnaam', [
    'gebruikersnaam' => $email
])->find();

$gebruikersnaam = $user['Gebruikersnaam'] ?? 'Onbekend';

// Pass data to the view
Core\Response::view('Account/Account', [
    'gebruikersnaam' => $gebruikersnaam,
]);
?>
