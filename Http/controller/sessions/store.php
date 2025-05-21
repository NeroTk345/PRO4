<?php

//login in the user if all the credentials match

use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if (!$form->validate($email, $password)) {
    return view('sessions/create.php', [
        'errors' => $form->errors()
    ]);
}
//match the credentials
$user = $db->query('SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email', [
    'email' => $email
])->find();

if ($user) {
    if (password_verify($password, $user['Wachtwoord'])) {
        login([
            'email' => $email
        ]);

        header('location: /');
        exit();
    }
}
//we have a user, but we don't know if the password provided matches what we have in the database.


return view('sessions/create.view.php', [
    'errors' => [
        'email' => 'Email-adress of wachtwoord verkeerd'
    ]
]);

