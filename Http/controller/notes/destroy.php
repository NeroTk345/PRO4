<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 1;

$note = $db->query('select * from melding where id = :id', [
    'id' => $_POST['id']
])->findOrFail();

authorize($note['GebruikerId'] === $currentUserId);

$db->query('delete from melding where id = :id', [
    'id' => $_POST['id']
]);

header('location: /notes');
exit();
