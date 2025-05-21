<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$notes = $db->query('SELECT * from melding')->get();


view("notes/index.view.php", [
    'heading' => 'My notes',
    'notes' => $notes
]);