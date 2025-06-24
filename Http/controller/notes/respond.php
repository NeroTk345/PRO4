<?php

require base_path('Core/Database.php');
$config = require base_path('config.php');
$db = new Core\Database($config['database']);

$note_id = $_POST['note_id'];
$response = $_POST['response'];

$db->query('UPDATE notes SET admin_response = :response WHERE id = :id', [
    'id' => $note_id,
    'response' => $response
]);

header('location: /notes');
exit();
