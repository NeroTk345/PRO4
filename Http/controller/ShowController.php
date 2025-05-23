<?php
// Http/controller/ShowController.php

use Models\Show;

class ShowController 
{
    public static function index()
    {
        $shows = Show::getAllWithDetails();
        $stats = Show::getStats();
        
        // Add status to each show
        $shows = array_map([Show::class, 'addStatus'], $shows);
        
        view("shows/index.view.php", [
            'heading' => 'Voorstellingen Overzicht',
            'shows' => $shows,
            'stats' => $stats
        ]);
    }
    
    public static function show($id)
    {
        $show = Show::find($id);
        
        if (!$show) {
            abort(404);
        }
        
        $show = Show::addStatus($show);
        $ticketsSold = Show::getTicketsSold($id);
        $availableTickets = Show::getAvailableTickets($id);
        $occupancyPercentage = Show::getOccupancyPercentage($show);
        
        view("shows/show.view.php", [
            'heading' => $show['Naam'],
            'show' => $show,
            'tickets_sold' => $ticketsSold,
            'available_tickets' => $availableTickets,
            'occupancy_percentage' => $occupancyPercentage
        ]);
    }
    
    public static function create()
    {
        view("shows/create.view.php", [
            'heading' => 'Nieuwe Voorstelling',
            'errors' => []
        ]);
    }
    
    public static function store()
    {
        $errors = static::validateShowData($_POST);
        
        if (!empty($errors)) {
            return view("shows/create.view.php", [
                'heading' => 'Nieuwe Voorstelling',
                'errors' => $errors
            ]);
        }
        
        $data = [
            'MedewerkerId' => $_POST['medewerker_id'],
            'Naam' => $_POST['naam'],
            'Beschrijving' => $_POST['beschrijving'],
            'Datum' => $_POST['datum'],
            'Tijd' => $_POST['tijd'],
            'MaxAantalTickets' => $_POST['max_tickets'],
            'Beschikbaarheid' => $_POST['beschikbaarheid'] ?? 'Beschikbaar',
            'Isactief' => 1,
            'Opmerking' => $_POST['opmerking'] ?? '',
            'Datumaangemaakt' => date('Y-m-d H:i:s'),
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ];
        
        Show::create($data);
        
        header('Location: /shows');
        exit();
    }
    
    public static function edit($id)
    {
        $show = Show::find($id);
        
        if (!$show) {
            abort(404);
        }
        
        view("shows/edit.view.php", [
            'heading' => 'Voorstelling Bewerken',
            'show' => $show,
            'errors' => []
        ]);
    }
    
    public static function update($id)
    {
        $show = Show::find($id);
        
        if (!$show) {
            abort(404);
        }
        
        $errors = static::validateShowData($_POST);
        
        if (!empty($errors)) {
            return view("shows/edit.view.php", [
                'heading' => 'Voorstelling Bewerken',
                'show' => $show,
                'errors' => $errors
            ]);
        }
        
        $data = [
            'MedewerkerId' => $_POST['medewerker_id'],
            'Naam' => $_POST['naam'],
            'Beschrijving' => $_POST['beschrijving'],
            'Datum' => $_POST['datum'],
            'Tijd' => $_POST['tijd'],
            'MaxAantalTickets' => $_POST['max_tickets'],
            'Beschikbaarheid' => $_POST['beschikbaarheid'],
            'Opmerking' => $_POST['opmerking'] ?? '',
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ];
        
        Show::update($id, $data);
        
        header('Location: /shows');
        exit();
    }
    
    public static function destroy($id)
    {
        $show = Show::find($id);
        
        if (!$show) {
            abort(404);
        }
        
        // Check if show has tickets sold
        $ticketsSold = Show::getTicketsSold($id);
        if ($ticketsSold > 0) {
            // Soft delete by setting Isactief to 0
            Show::update($id, [
                'Isactief' => 0,
                'Datumgewijzigd' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Hard delete if no tickets sold
            Show::delete($id);
        }
        
        header('Location: /shows');
        exit();
    }
    
    public static function toggleStatus($id)
    {
        $show = Show::find($id);
        
        if (!$show) {
            abort(404);
        }
        
        $newStatus = $show['Isactief'] ? 0 : 1;
        
        Show::update($id, [
            'Isactief' => $newStatus,
            'Datumgewijzigd' => date('Y-m-d H:i:s')
        ]);
        
        header('Location: /shows');
        exit();
    }
    
    public static function upcoming()
    {
        $shows = Show::getUpcoming();
        $shows = array_map([Show::class, 'addStatus'], $shows);
        
        view("shows/upcoming.view.php", [
            'heading' => 'Komende Voorstellingen',
            'shows' => $shows
        ]);
    }
    
    public static function today()
    {
        $shows = Show::getToday();
        $shows = array_map([Show::class, 'addStatus'], $shows);
        
        view("shows/today.view.php", [
            'heading' => 'Voorstellingen Vandaag',
            'shows' => $shows
        ]);
    }
    
    private static function validateShowData($data)
    {
        $errors = [];
        
        if (empty($data['naam']) || strlen($data['naam']) < 3) {
            $errors['naam'] = 'Naam moet minimaal 3 karakters zijn';
        }
        
        if (empty($data['datum'])) {
            $errors['datum'] = 'Datum is verplicht';
        } elseif (strtotime($data['datum']) < strtotime('today')) {
            $errors['datum'] = 'Datum kan niet in het verleden zijn';
        }
        
        if (empty($data['tijd'])) {
            $errors['tijd'] = 'Tijd is verplicht';
        }
        
        if (empty($data['max_tickets']) || !is_numeric($data['max_tickets']) || $data['max_tickets'] < 1) {
            $errors['max_tickets'] = 'Maximum aantal tickets moet een positief getal zijn';
        }
        
        if (empty($data['medewerker_id']) || !is_numeric($data['medewerker_id'])) {
            $errors['medewerker_id'] = 'Een geldige medewerker moet worden geselecteerd';
        }
        
        return $errors;
    }
}