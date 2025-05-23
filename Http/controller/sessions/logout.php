<?php
// Http/controller/sessions/logout.php

use Core\App;
use Core\Database;

// Update logout timestamp before destroying session
if (isset($_SESSION['user']['id'])) {
    $db = App::resolve(Database::class);
    $db->query('UPDATE Gebruiker SET IsIngelogd = 0, Uitgelogd = NOW() WHERE Id = :id', [
        'id' => $_SESSION['user']['id']
    ]);
}

session_start();
session_unset();
session_destroy();

header('Location: /');
exit();