<?php

use Core\App;
use Core\Database;
use Core\Validator;

$voornaam = $_POST['voornaam'] ?? '';
$achternaam = $_POST['achternaam'] ?? '';
$email = $_POST['email'];
$password = $_POST['password'];


$errors = [];
    if (!Validator::string($voornaam, 2, 50)) {
        $errors['voornaam'] = 'Graag een geldige voornaam invullen';
    }
    if (!Validator::string($achternaam, 2, 50)) {
        $errors['achternaam'] = 'Graag een geldige achternaam invullen';
    }
    if (!Validator::email($email)) {
        $errors['email'] = 'Graag een geldig email adress';
    }
    if (!Validator::string($password, 7, 80)) {
        $errors['password'] = 'Wachtwoord moet meer dan 7 characters zijn';
    }

    if (!empty($errors)) {
        return view('Regristration/create.view.php', [
            'errors' => $errors
        ]);
    }

    $db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email', [
    'email' => $email
])->find();

    if ($user) {
        header('location: /');
        exit();
    }

try {
    $db->query('INSERT INTO Gebruiker (Voornaam, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd) VALUES (:voornaam, :achternaam, :gebruikersnaam, :wachtwoord, 1, 1, NOW(), NOW())', [
        'voornaam' => $voornaam,
        'achternaam' => $achternaam,
        'gebruikersnaam' => $email,
        'wachtwoord' => password_hash($password, PASSWORD_BCRYPT)
    ]);
} catch (PDOException $e) {
    dd($e->getMessage());
}

    // Haal de gebruiker opnieuw op om te kunnen inloggen
    $user = $db->query('SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email', [
        'email' => $email
    ])->find();
    

    header('location: /login');
    exit();

