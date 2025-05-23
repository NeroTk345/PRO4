<?php

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if (!$form->validate($email, $password)) {
    return view('sessions/create.view.php', [
        'errors' => $form->errors()
    ]);
}

$user = $db->query('SELECT Id, Gebruikersnaam, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :email', [
    'email' => $email
])->find();

if ($user) {
    if (password_verify($password, $user['Wachtwoord'])) {
        login([
            'id' => $user['Id'],
            'email' => $email
        ]);

        $role = $db->query('SELECT Naam FROM Rol WHERE GebruikerId = :id', [
            'id' => $user['Id']
        ])->find();
        
        if ($role) {
            $_SESSION['user']['role'] = $role['Naam'];
        } else {
            $_SESSION['user']['role'] = 'Gebruiker';
        }

        header('location: /');
        exit();
    }
}

return view('sessions/create.view.php', [
    'errors' => [
        'email' => 'Email-adres of wachtwoord verkeerd'
    ]
]);