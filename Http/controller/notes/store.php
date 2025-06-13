<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['gebruiker_id']) && isset($_POST['melding_id']) && isset($_POST['inhoud'])) {
    $gebruikerId = $_POST['gebruiker_id'];
    $meldingId = $_POST['melding_id'];

    // Zet melding_id op null als het leeg is
    if ($meldingId === '' || !is_numeric($meldingId)) {
        $meldingId = null;
    } else {
        $meldingId = (int)$meldingId;  // Cast naar integer als het wel een nummer is
    }

    $inhoud = $_POST['inhoud'];

    $db->query('INSERT INTO reactie (gebruiker_id, melding_id, inhoud) VALUES (:gebruiker_id, :melding_id, :inhoud)', [
        'gebruiker_id' => $gebruikerId,
        'melding_id' => $meldingId,
        'inhoud' => $inhoud,
    ]);
    header('Location: /notes');
    exit();
}


$gebruikerId = $_SESSION['user']['id'] ?? null;
$bericht = $_POST['Bericht'] ?? '';
$voorstelling = $_POST['voorstelling'] ?? '';
$datum = $_POST['datum'] ?? '';
$tijd = $_POST['tijd'] ?? '';

$errors = [];

if (!Validator::string($bericht, 1, 200)) {
    $errors['Bericht'] = 'Een bericht van maximaal 1000 tekens is verplicht.';
}
if (!Validator::string($voorstelling, 1, 100)) {
    $errors['voorstelling'] = 'Voorstelling is verplicht.';
}
if (empty($datum)) {
    $errors['datum'] = 'Datum is verplicht.';
}
if (empty($tijd)) {
    $errors['tijd'] = 'Tijd is verplicht.';
}

if (!empty($errors)) {
    return view("index.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors,
    ]);
}

// Bereken het volgende unieke Nummer
$stmt = $db->query("SELECT MAX(Nummer) AS max FROM melding");
$maxNummer = $stmt->find()['max'] ?? 0;
$nieuwNummer = $maxNummer + 1;

// Voeg de melding toe met het nieuwe Nummer en extra velden
$db->query('INSERT INTO melding (Nummer, Bericht, GebruikerId, Voorstelling, Datum, Tijd, Datumaangemaakt, Datumgewijzigd) 
    VALUES (:Nummer, :Bericht, :GebruikerId, :Voorstelling, :Datum, :Tijd, NOW(), NOW())', [
    'Nummer' => $nieuwNummer,
    'Bericht' => $bericht,
    'GebruikerId' => $gebruikerId,
    'Voorstelling' => $voorstelling,
    'Datum' => $datum,
    'Tijd' => $tijd,
]);

header('Location: /notes');
exit();
