<?php
$config = require __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../../../Core/Database.php';

use Core\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Id'])) {
    $id = $_POST['Id'];
    $db = new Database($config['database']);
    $db->query('DELETE FROM voorstelling WHERE Id = ?', [$id]);
    header('Location: /shows');
    exit;
} else {
    http_response_code(400);
    echo 'Ongeldige aanvraag.';
    exit;
}
