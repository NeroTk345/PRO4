<?php

namespace App\Http\Controllers;

use Core\App;
use Core\Database;
use Core\Validator;
use Http\Forms\LoginForm;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return $this->view('sessions/create.view');
    }
    
    public function login()
    {
        $db = App::resolve(Database::class);
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $form = new LoginForm();
        
        if (!$form->validate($email, $password)) {
            return $this->view('sessions/create.view', [
                'errors' => $form->errors()
            ]);
        }
        
        $user = $db->query('SELECT Id, Gebruikersnaam, Wachtwoord FROM Gebruiker WHERE Gebruikersnaam = :email', [
            'email' => $email
        ])->find();
        
        if ($user && password_verify($password, $user['Wachtwoord'])) {
            // Login the user
            $_SESSION['user'] = [
                'id' => $user['Id'],
                'email' => $email
            ];
            
            // Get user role
            $role = $db->query('SELECT Naam FROM Rol WHERE GebruikerId = :id AND Isactief = 1', [
                'id' => $user['Id']
            ])->find();
            
            $_SESSION['user']['role'] = $role ? $role['Naam'] : 'Gebruiker';
            
            // Update login status
            $db->query('UPDATE Gebruiker SET IsIngelogd = 1, Ingelogd = NOW() WHERE Id = :id', [
                'id' => $user['Id']
            ]);
            
            session_regenerate_id(true);
            
            return $this->redirect('/');
        }
        
        return $this->view('sessions/create.view', [
            'errors' => [
                'email' => 'Email-adres of wachtwoord verkeerd'
            ]
        ]);
    }
    
    public function logout()
    {
        if (isset($_SESSION['user']['id'])) {
            $db = App::resolve(Database::class);
            $db->query('UPDATE Gebruiker SET IsIngelogd = 0, Uitgelogd = NOW() WHERE Id = :id', [
                'id' => $_SESSION['user']['id']
            ]);
        }
        
        session_unset();
        session_destroy();
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        return $this->redirect('/');
    }
    
    public function showRegisterForm()
    {
        return $this->view('Regristration/create.view');
    }
    
    public function register()
    {
        $db = App::resolve(Database::class);
        
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
            $errors['email'] = 'Graag een geldig email adres';
        }
        if (!Validator::string($password, 7, 80)) {
            $errors['password'] = 'Wachtwoord moet meer dan 7 karakters zijn';
        }
        
        if (!empty($errors)) {
            return $this->view('Regristration/create.view', [
                'errors' => $errors
            ]);
        }
        
        // Check if user exists
        $user = $db->query('SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email', [
            'email' => $email
        ])->find();
        
        if ($user) {
            return $this->redirect('/');
        }
        
        // Create new user
        $db->query('INSERT INTO Gebruiker (Voornaam, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd) VALUES (:voornaam, :achternaam, :gebruikersnaam, :wachtwoord, 0, 1, NOW(), NOW())', [
            'voornaam' => $voornaam,
            'achternaam' => $achternaam,
            'gebruikersnaam' => $email,
            'wachtwoord' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        
        return $this->redirect('/login');
    }
}