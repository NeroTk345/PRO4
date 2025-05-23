<?php
// Http/controller/AccountController.php

use Models\Account;

class AccountController
{
    public static function index()
    {
        $accounts = Account::getAllWithDetails();
        $stats = Account::getStats();
        
        view("accounts/index.view.php", [
            'heading' => 'Accounts Overzicht',
            'accounts' => $accounts,
            'stats' => $stats
        ]);
    }
    
    public static function show($id)
    {
        $account = Account::find($id);
        
        if (!$account) {
            abort(404);
        }
        
        view("accounts/show.view.php", [
            'heading' => 'Account Details',
            'account' => $account
        ]);
    }
    
    public static function create()
    {
        view("accounts/create.view.php", [
            'heading' => 'Nieuw Account',
            'errors' => []
        ]);
    }
    
    public static function store()
    {
        $errors = static::validateAccountData($_POST);
        
        if (!empty($errors)) {
            return view("accounts/create.view.php", [
                'heading' => 'Nieuw Account',
                'errors' => $errors
            ]);
        }
        
        $data = [
            'Voornaam' => $_POST['voornaam'],
            'Achternaam' => $_POST['achternaam'],
            'Gebruikersnaam' => $_POST['email'],
            'Wachtwoord' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'IsIngelogd' => 0,
            'Isactief' => 1,
            'Datumaangemaakt' => date('Y-m-d H:i:s'),
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ];
        
        Account::create($data);
        
        header('Location: /accounts');
        exit();
    }
    
    public static function edit($id)
    {
        $account = Account::find($id);
        
        if (!$account) {
            abort(404);
        }
        
        view("accounts/edit.view.php", [
            'heading' => 'Account Bewerken',
            'account' => $account,
            'errors' => []
        ]);
    }
    
    public static function update($id)
    {
        $account = Account::find($id);
        
        if (!$account) {
            abort(404);
        }
        
        $errors = static::validateAccountData($_POST, $id);
        
        if (!empty($errors)) {
            return view("accounts/edit.view.php", [
                'heading' => 'Account Bewerken',
                'account' => $account,
                'errors' => $errors
            ]);
        }
        
        $data = [
            'Voornaam' => $_POST['voornaam'],
            'Achternaam' => $_POST['achternaam'],
            'Gebruikersnaam' => $_POST['email'],
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ];
        
        if (!empty($_POST['password'])) {
            $data['Wachtwoord'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }
        
        Account::update($id, $data);
        
        header('Location: /accounts');
        exit();
    }
    
    public static function destroy($id)
    {
        $account = Account::find($id);
        
        if (!$account) {
            abort(404);
        }
        
        // Soft delete by setting Isactief to 0
        Account::update($id, [
            'Isactief' => 0,
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ]);
        
        header('Location: /accounts');
        exit();
    }
    
    public static function toggleStatus($id)
    {
        $account = Account::find($id);
        
        if (!$account) {
            abort(404);
        }
        
        $newStatus = $account['Isactief'] ? 0 : 1;
        
        Account::update($id, [
            'Isactief' => $newStatus,
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ]);
        
        header('Location: /accounts');
        exit();
    }
    
    private static function validateAccountData($data, $excludeId = null)
    {
        $errors = [];
        
        if (empty($data['voornaam']) || strlen($data['voornaam']) < 2) {
            $errors['voornaam'] = 'Voornaam moet minimaal 2 karakters zijn';
        }
        
        if (empty($data['achternaam']) || strlen($data['achternaam']) < 2) {
            $errors['achternaam'] = 'Achternaam moet minimaal 2 karakters zijn';
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Een geldig email adres is verplicht';
        } else {
            // Check if email already exists
            $existingAccount = Account::findByEmail($data['email']);
            if ($existingAccount && $existingAccount['Id'] != $excludeId) {
                $errors['email'] = 'Dit email adres is al in gebruik';
            }
        }
        
        if (!$excludeId && (empty($data['password']) || strlen($data['password']) < 6)) {
            $errors['password'] = 'Wachtwoord moet minimaal 6 karakters zijn';
        }
        
        return $errors;
    }
}