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
$user = $db->query('SELECT id, Gebruikersnaam, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :email', [
    'email' => $email
])->find();

var_dump($user); // Debugging to check if 'id' is retrieved correctly

if ($user) {
    if (password_verify($password, $user['Wachtwoord'])) {
        login([
            'id' => $user['id'],
            'email' => $email
        ]);

        $role = $db->query('SELECT Naam FROM rol WHERE Gebruikerid = :id', [
            'id' => $user['id']
        ])->find();
        if ($role) {
            $_SESSION['user']['role'] = $role['Naam'];
        } else {
            $_SESSION['user']['role'] = 'Geen rol gevonden';
        }

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

