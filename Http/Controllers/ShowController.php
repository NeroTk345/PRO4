<?php

namespace App\Http\Controllers;

use Core\App;
use Core\Database;
use Models\Show;

class ShowController extends Controller
{
    private $db;
    
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
    
    public function index()
    {
        $shows = Show::getAllWithDetails();
        $shows = array_map([Show::class, 'addStatus'], $shows);
        
        return $this->view('shows/index.view', [
            'heading' => 'Voorstellingen Overzicht',
            'shows' => $shows
        ]);
    }
}