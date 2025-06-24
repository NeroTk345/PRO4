<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 1;

    if (!isset($_GET['id'])) {
    // Geen id meegegeven, terug naar overzicht
    header('Location: /notes');
    exit();
}

$note = $db->query('select * from melding where id = :id', [
    'id' => $_GET['id']
])->findOrFail();

authorize($note['GebruikerId'] === $currentUserId);

view("notes/show.view.php", [
    'heading' => 'Note',
    'note' => $note
]);
