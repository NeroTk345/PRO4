<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$id = $_POST['Id'];
if (!empty($id)) {
    // First, delete the role associated with the user to prevent orphaned data.
    $db->query('DELETE FROM rol WHERE GebruikerId = :id', ['id' => $id]);
    
    // Then, delete the user.
    $db->query('DELETE FROM gebruiker WHERE Id = :id', ['id' => $id]);
}

header('Location: /admin/members');
exit();

