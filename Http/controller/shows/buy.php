<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Id'])) {
    $config = require base_path('config.php');
    $db = new \Core\Database($config['database'], $config['database']['username'], $config['database']['password']);
    $id = (int)$_POST['Id'];

    // Haal huidig aantal tickets op
    $show = $db->query('SELECT MaxAantalTickets FROM voorstelling WHERE Id = ?', [$id])->find();
    if ($show && $show['MaxAantalTickets'] > 0) {
        // Verlaag aantal met 1
        $db->query('UPDATE voorstelling SET MaxAantalTickets = MaxAantalTickets - 1 WHERE Id = ?', [$id]);
        // Controleer of het aantal nu 0 is en zet Beschikbaarheid op Uitverkocht
        $updatedShow = $db->query('SELECT MaxAantalTickets FROM voorstelling WHERE Id = ?', [$id])->find();
        if ($updatedShow && $updatedShow['MaxAantalTickets'] == 0) {
            $db->query('UPDATE voorstelling SET Beschikbaarheid = ? WHERE Id = ?', ['Uitverkocht', $id]);
        }
    }
}
// Altijd naar succespagina
header('Location: /shows/buy/success');
exit;
