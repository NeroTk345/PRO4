<?php



use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$voorstellingen = $db->query("SELECT id, naam FROM voorstelling")->get();

view("notes/create.view.php", [
    'heading' => 'Create Note',
    'errors' => [],
    'voorstellingen' => $voorstellingen
]);