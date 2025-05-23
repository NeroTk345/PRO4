<?php

namespace App\Http\Controllers;

use Core\App;
use Core\Database;
use Models\Account;

class AccountController extends Controller
{
    private $db;
    
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
    
    public function index()
    {
        $accounts = Account::getAllWithDetails();
        $stats = Account::getStats();
        
        return $this->view('accounts/index.view', [
            'heading' => 'Accounts Overzicht',
            'accounts' => $accounts,
            'stats' => $stats
        ]);
    }
    
    public function profile()
    {
        $email = $this->currentUser()['email'] ?? 'Niet beschikbaar';
        
        $user = $this->db->query('SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam = :email', [
            'email' => $email
        ])->find();
        
        $gebruikersnaam = $user['Gebruikersnaam'] ?? 'Onbekend';
        
        return $this->view('Account/Account', [
            'gebruikersnaam' => $gebruikersnaam,
        ]);
    }
}