<?php

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$form = new LoginForm();

if (!$form->validate($email, $password)) {
    return view('sessions/create.php', [
        'errors' => $form->errors()
    ]);
}

try {
    // Zoek gebruiker op basis van gebruikersnaam (email)
    $user = $db->query('SELECT id, Gebruikersnaam, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :email', [
        'email' => $email
    ])->find();

    if ($user && password_verify($password, $user['Wachtwoord'])) {
        // Login gebruiker
        login([
            'id' => $user['id'],
            'email' => $email
        ]);

        // Haal de rol van de gebruiker op
        $role = $db->query('SELECT Naam FROM rol WHERE Gebruikerid = :id', [
            'id' => $user['id']
        ])->find();

        $_SESSION['user']['role'] = $role['Naam'] ?? 'Geen rol gevonden';

        header('Location: /');
        exit();
    }

    // Als we hier komen: gebruiker niet gevonden of wachtwoord ongeldig
    return view('sessions/create.view.php', [
        'errors' => [
            'email' => 'Email-adres of wachtwoord verkeerd'
        ]
    ]);
} catch (Exception $e) {
    // Log eventueel de fout of toon een aangepaste foutpagina
    error_log($e->getMessage());

    return view('sessions/create.view.php', [
        'errors' => [
            'email' => 'Er is een fout opgetreden. Probeer het later opnieuw.'
        ]
    ]);
}
