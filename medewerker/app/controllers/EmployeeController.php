<?php
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/db.php';

class EmployeeController {
    public function overzicht() {
        $pdo = getPDO();

        // --- Server-side validation for adding a medewerker ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
            $name = trim($_POST['name']);
            $role = $_POST['role'];
            $validRoles = ['Manager', 'Medewerker'];
            if ($name !== '' && in_array($role, $validRoles)) {
                // --- Try-catch block for database operations and error handling ---
                try {
                    // Check if name already exists (server-side validation)
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM medewerkers WHERE naam = ?");
                    $stmt->execute([$name]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = "Deze naam bestaat al!";
                    } else {
                        // If name is unique, insert new medewerker
                        Employee::create($pdo, $name, $role);
                        header('Location: medewerker.php');
                        exit;
                    }
                } catch (Exception $e) {
                    // --- Catch block: handles any database errors, including UNIQUE constraint violation ---
                    $error = "Fout bij toevoegen: " . $e->getMessage();
                }
            } else {
                // --- Server-side validation failed ---
                $error = "Vul een geldige naam en rol in.";
            }
        }

        // --- Server-side validation for editing a medewerker ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_name = trim($_POST['edit_name']);
            $edit_role = $_POST['edit_role'];
            $validRoles = ['Manager', 'Medewerker'];
            if ($edit_name !== '' && in_array($edit_role, $validRoles)) {
                // --- Try-catch for database errors ---
                try {
                    Employee::update($pdo, $edit_id, $edit_name, $edit_role);
                    header('Location: medewerker.php');
                    exit;
                } catch (Exception $e) {
                    $error = "Fout bij bewerken: " . $e->getMessage();
                }
            } else {
                $error = "Vul een geldige naam en rol in.";
            }
        }

        // --- Try-catch for deleting a medewerker ---
        if (isset($_GET['delete'])) {
            try {
                Employee::delete($pdo, $_GET['delete']);
                header('Location: medewerker.php');
                exit;
            } catch (Exception $e) {
                $error = "Fout bij verwijderen: " . $e->getMessage();
            }
        }

        $employees = Employee::all($pdo);
        include __DIR__ . '/../views/medewerker_list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = getPDO();
            Employee::create($pdo, $_POST['name'], $_POST['role']);
            header('Location: medewerker.php');
            exit;
        }
        include __DIR__ . '/../views/medewerker_create.php';
    }

    public function edit($id) {
        $pdo = getPDO();
        $employee = Employee::find($pdo, $id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Employee::update($pdo, $id, $_POST['name'], $_POST['role']);
            header('Location: medewerker.php');
            exit;
        }
        include __DIR__ . '/../views/medewerker_edit.php';
    }

    public function delete($id) {
        $pdo = getPDO();
        Employee::delete($pdo, $id);
        header('Location: medewerker.php');
        exit;
    }
}