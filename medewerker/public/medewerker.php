<?php
session_start();
if (!isset($_SESSION['medewerker_logged_in']) || $_SESSION['medewerker_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../app/controllers/EmployeeController.php';

$controller = new EmployeeController();
$controller->overzicht();
