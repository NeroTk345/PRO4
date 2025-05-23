<?php
// Models/Account.php

namespace Models;

use Core\Model;

class Account extends Model
{
    protected static $table = 'Gebruiker';
    
    public static function getAllWithDetails()
    {
        return static::db()->query('
            SELECT 
                u.Id,
                u.Voornaam,
                u.Tussenvoegsel,
                u.Achternaam, 
                u.Gebruikersnaam as email,
                u.IsIngelogd,
                u.Ingelogd,
                u.Uitgelogd,
                u.Isactief,
                u.Opmerking,
                u.Datumaangemaakt,
                u.Datumgewijzigd,
                COALESCE(r.Naam, "Geen rol") as rol_naam,
                c.Email as contact_email,
                c.Mobiel,
                m.Nummer as medewerker_nummer,
                m.Medewerkersoort,
                b.Relatienummer as bezoeker_nummer,
                CASE 
                    WHEN m.Id IS NOT NULL THEN "Medewerker"
                    WHEN b.Id IS NOT NULL THEN "Bezoeker" 
                    ELSE "Onbekend"
                END as gebruiker_type
            FROM Gebruiker u
            LEFT JOIN Rol r ON u.Id = r.GebruikerId AND r.Isactief = 1
            LEFT JOIN Contact c ON u.Id = c.GebruikerId AND c.Isactief = 1
            LEFT JOIN Medewerker m ON u.Id = m.GebruikerId AND m.Isactief = 1
            LEFT JOIN Bezoeker b ON u.Id = b.GebruikerId AND b.Isactief = 1
            ORDER BY u.Datumaangemaakt DESC
        ')->get();
    }
    
    public static function getStats()
    {
        $accounts = static::getAllWithDetails();
        
        return [
            'total' => count($accounts),
            'active' => count(array_filter($accounts, fn($account) => $account['Isactief'] == 1)),
            'employees' => count(array_filter($accounts, fn($account) => $account['gebruiker_type'] === 'Medewerker')),
            'visitors' => count(array_filter($accounts, fn($account) => $account['gebruiker_type'] === 'Bezoeker')),
            'admins' => count(array_filter($accounts, fn($account) => $account['rol_naam'] === 'Admin')),
            'online' => count(array_filter($accounts, fn($account) => $account['IsIngelogd'] == 1))
        ];
    }
    
    public static function getByRole($role)
    {
        return static::db()->query('
            SELECT u.*, r.Naam as rol_naam
            FROM Gebruiker u
            LEFT JOIN Rol r ON u.Id = r.GebruikerId
            WHERE r.Naam = :role AND r.Isactief = 1
        ', ['role' => $role])->get();
    }
    
    public static function getActiveAccounts()
    {
        return static::where('Isactief', 1);
    }
    
    public static function findByEmail($email)
    {
        return static::db()->query(
            'SELECT * FROM Gebruiker WHERE Gebruikersnaam = :email',
            ['email' => $email]
        )->find();
    }
    
    public static function updateLoginStatus($id, $isLoggedIn)
    {
        $data = [
            'IsIngelogd' => $isLoggedIn ? 1 : 0,
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ];
        
        if ($isLoggedIn) {
            $data['Ingelogd'] = date('Y-m-d H:i:s');
        } else {
            $data['Uitgelogd'] = date('Y-m-d H:i:s');
        }
        
        return static::update($id, $data);
    }
    
    public static function getFullName($account)
    {
        return trim($account['Voornaam'] . ' ' . 
                   ($account['Tussenvoegsel'] ? $account['Tussenvoegsel'] . ' ' : '') . 
                   $account['Achternaam']);
    }
    
    public static function getInitials($account)
    {
        return strtoupper(substr($account['Voornaam'], 0, 1) . substr($account['Achternaam'], 0, 1));
    }
}