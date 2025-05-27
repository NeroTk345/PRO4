<?php
require_once __DIR__ . '/../app/controllers/EmployeeController.php';
$id = $_GET['id'] ?? null;
$controller = new EmployeeController();
$controller->edit($id);