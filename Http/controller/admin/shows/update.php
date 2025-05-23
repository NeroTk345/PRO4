<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

// Controleer beheerders toegang
$currentUserId = $_SESSION['user']['id'] ?? null;
$userRole = $_SESSION['user']['role'] ?? null;

if (!$currentUserId || ($userRole !== 'Beheerder' && $userRole !== 'Admin')) {
    header('Location: /');
    exit();
}

$voorstellingId = $_POST['id'];
$voorstelling = $db->query('SELECT * FROM voorstellingen WHERE id = :id', [
    'id' => $voorstellingId
])->findOrFail();

$errors = [];

// Validatie
$titel = $_POST['titel'] ?? '';
$beschrijving = $_POST['beschrijving'] ?? '';
$datum = $_POST['datum'] ?? '';
$tijd = $_POST['tijd'] ?? '';
$prijs = $_POST['prijs'] ?? '';
$max_bezoekers = $_POST['max_bezoekers'] ?? '';
$locatie = $_POST['locatie'] ?? '';
$afbeelding_url = $_POST['afbeelding_url'] ?? '';
$status = $_POST['status'] ?? 'actief';

if (!Validator::string($titel, 1, 255)) {
    $errors['titel'] = 'Titel is verplicht en mag maximaal 255 karakters zijn.';
}

if (!Validator::string($beschrijving, 1, 1000)) {
    $errors['beschrijving'] = 'Beschrijving is verplicht en mag maximaal 1000 karakters zijn.';
}

if (empty($datum) || !strtotime($datum)) {
    $errors['datum'] = 'Geldige datum is verplicht.';
}

if (empty($tijd) || !strtotime($tijd)) {
    $errors['tijd'] = 'Geldige tijd is verplicht.';
}

if (!is_numeric($prijs) || $prijs < 0) {
    $errors['prijs'] = 'Geldige prijs is verplicht.';
}

if (!is_numeric($max_bezoekers) || $max_bezoekers < 1) {
    $errors['max_bezoekers'] = 'Maximaal aantal bezoekers moet minimaal 1 zijn.';
}

if (!Validator::string($locatie, 1, 255)) {
    $errors['locatie'] = 'Locatie is verplicht.';
}

if (!empty($errors)) {
    return view("admin/shows/edit.view.php", [
        'heading' => 'Voorstelling Bewerken',
        'voorstelling' => $voorstelling,
        'errors' => $errors
    ]);
}

// Update database
try {
    $db->query('
        UPDATE voorstellingen 
        SET titel = :titel, beschrijving = :beschrijving, datum = :datum, 
            tijd = :tijd, prijs = :prijs, max_bezoekers = :max_bezoekers, 
            locatie = :locatie, afbeelding_url = :afbeelding_url, status = :status,
            gewijzigd_op = NOW()
        WHERE id = :id
    ', [
        'id' => $voorstellingId,
        'titel' => $titel,
        'beschrijving' => $beschrijving,
        'datum' => $datum,
        'tijd' => $tijd,
        'prijs' => $prijs,
        'max_bezoekers' => $max_bezoekers,
        'locatie' => $locatie,
        'afbeelding_url' => $afbeelding_url,
        'status' => $status
    ]);

    $_SESSION['success_message'] = 'Voorstelling succesvol bijgewerkt!';
    header('Location: /admin/shows');
    exit();

} catch (PDOException $e) {
    error_log('Voorstelling bijwerken fout: ' . $e->getMessage());
    
    return view("admin/shows/edit.view.php", [
        'heading' => 'Voorstelling Bewerken',
        'voorstelling' => $voorstelling,
        'errors' => ['general' => 'Er is een fout opgetreden bij het bijwerken.']
    ]);
}