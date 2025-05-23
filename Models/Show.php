<?php
// Models/Show.php

namespace Models;

use Core\Model;
use DateTime;

class Show extends Model
{
    protected static $table = 'Voorstelling';
    
    public static function getAllWithDetails()
    {
        return static::db()->query('
            SELECT 
                v.Id,
                v.Naam,
                v.Beschrijving,
                v.Datum,
                v.Tijd,
                v.MaxAantalTickets,
                v.Beschikbaarheid,
                v.Isactief,
                v.Opmerking,
                v.Datumaangemaakt,
                v.Datumgewijzigd,
                CONCAT(u.Voornaam, " ", u.Achternaam) as medewerker_naam,
                m.Nummer as medewerker_nummer,
                m.Medewerkersoort,
                COUNT(t.Id) as tickets_verkocht,
                (v.MaxAantalTickets - COUNT(t.Id)) as tickets_beschikbaar
            FROM Voorstelling v
            LEFT JOIN Medewerker m ON v.MedewerkerId = m.Id
            LEFT JOIN Gebruiker u ON m.GebruikerId = u.Id
            LEFT JOIN Ticket t ON v.Id = t.VoorstellingId AND t.Isactief = 1
            GROUP BY v.Id, v.Naam, v.Beschrijving, v.Datum, v.Tijd, v.MaxAantalTickets, 
                     v.Beschikbaarheid, v.Isactief, v.Opmerking, v.Datumaangemaakt, v.Datumgewijzigd,
                     u.Voornaam, u.Achternaam, m.Nummer, m.Medewerkersoort
            ORDER BY v.Datum DESC, v.Tijd DESC
        ')->get();
    }
    
    public static function getStats()
    {
        $shows = static::getAllWithDetails();
        $showsWithStatus = array_map([static::class, 'addStatus'], $shows);
        
        return [
            'total' => count($shows),
            'active' => count(array_filter($shows, fn($show) => $show['Isactief'] == 1)),
            'upcoming' => count(array_filter($showsWithStatus, fn($show) => $show['status'] === 'toekomstig')),
            'sold_out' => count(array_filter($showsWithStatus, fn($show) => $show['status'] === 'uitverkocht')),
            'completed' => count(array_filter($showsWithStatus, fn($show) => $show['status'] === 'voltooid')),
            'today' => count(array_filter($showsWithStatus, fn($show) => $show['status'] === 'bezig'))
        ];
    }
    
    public static function addStatus($show)
    {
        $showDateTime = new DateTime($show['Datum'] . ' ' . $show['Tijd']);
        $now = new DateTime();
        
        if ($show['Datum'] < date('Y-m-d')) {
            $status = 'voltooid';
        } elseif ($show['Datum'] == date('Y-m-d') && $show['Tijd'] < date('H:i:s')) {
            $status = 'bezig';
        } elseif ($show['tickets_verkocht'] >= $show['MaxAantalTickets']) {
            $status = 'uitverkocht';
        } elseif ($show['Datum'] > date('Y-m-d') || ($show['Datum'] == date('Y-m-d') && $show['Tijd'] > date('H:i:s'))) {
            $status = 'toekomstig';
        } else {
            $status = 'onbekend';
        }
        
        $show['status'] = $status;
        return $show;
    }
    
    public static function getUpcoming()
    {
        return static::db()->query('
            SELECT * FROM Voorstelling 
            WHERE Datum >= CURDATE() AND Isactief = 1
            ORDER BY Datum ASC, Tijd ASC
        ')->get();
    }
    
    public static function getByDate($date)
    {
        return static::db()->query(
            'SELECT * FROM Voorstelling WHERE Datum = :date',
            ['date' => $date]
        )->get();
    }
    
    public static function getToday()
    {
        return static::getByDate(date('Y-m-d'));
    }
    
    public static function getTicketsSold($showId)
    {
        $result = static::db()->query(
            'SELECT COUNT(*) as count FROM Ticket WHERE VoorstellingId = :id AND Isactief = 1',
            ['id' => $showId]
        )->find();
        
        return $result['count'] ?? 0;
    }
    
    public static function getAvailableTickets($showId)
    {
        $show = static::find($showId);
        if (!$show) return 0;
        
        $sold = static::getTicketsSold($showId);
        return max(0, $show['MaxAantalTickets'] - $sold);
    }
    
    public static function isSoldOut($showId)
    {
        return static::getAvailableTickets($showId) <= 0;
    }
    
    public static function getOccupancyPercentage($show)
    {
        if ($show['MaxAantalTickets'] <= 0) return 0;
        return round(($show['tickets_verkocht'] / $show['MaxAantalTickets']) * 100, 1);
    }
    
    public static function getTimeUntilShow($show)
    {
        $showDateTime = new DateTime($show['Datum'] . ' ' . $show['Tijd']);
        $now = new DateTime();
        
        if ($showDateTime > $now) {
            $diff = $now->diff($showDateTime);
            if ($diff->days > 0) {
                return "Over {$diff->days} dagen";
            } elseif ($diff->h > 0) {
                return "Over {$diff->h} uur";
            } else {
                return "Binnenkort";
            }
        } elseif ($showDateTime->format('Y-m-d') === $now->format('Y-m-d')) {
            return "Vandaag";
        } else {
            $diff = $showDateTime->diff($now);
            return "{$diff->days} dagen geleden";
        }
    }
    
    public static function getStatusColor($status)
    {
        $colors = [
            'toekomstig' => 'bg-blue-100 text-blue-800',
            'bezig' => 'bg-yellow-100 text-yellow-800',
            'voltooid' => 'bg-gray-100 text-gray-800',
            'uitverkocht' => 'bg-red-100 text-red-800'
        ];
        
        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }
    
    public static function getStatusText($status)
    {
        $texts = [
            'toekomstig' => 'Toekomstig',
            'bezig' => 'Bezig',
            'voltooid' => 'Voltooid',
            'uitverkocht' => 'Uitverkocht'
        ];
        
        return $texts[$status] ?? ucfirst($status);
    }
}