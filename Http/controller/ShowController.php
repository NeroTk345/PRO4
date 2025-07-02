<?php

class ShowController
{
    public static function index()
    {
        $config = require base_path('config.php');
        $db = new \Core\Database($config['database'], $config['database']['username'], $config['database']['password']);
        $shows = $db->query('SELECT * FROM voorstelling')->get();
        $heading = 'Shows overzicht';
        require base_path('views/shows/index.view.php');
    }
}
