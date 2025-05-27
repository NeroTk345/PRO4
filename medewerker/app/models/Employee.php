<?php
class Employee {
    public $id;
    public $name;
    public $role;

    public function __construct($id, $name, $role) {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
    }

    public static function all($pdo) {
        $stmt = $pdo->query("SELECT * FROM medewerkers");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Employee($row['id'], $row['naam'], $row['rol']);
        }
        return $result;
    }

    public static function find($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM medewerkers WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Employee($row['id'], $row['naam'], $row['rol']);
        }
        return null;
    }

    public static function create($pdo, $name, $role) {
        $stmt = $pdo->prepare("INSERT INTO medewerkers (naam, rol) VALUES (?, ?)");
        $stmt->execute([$name, $role]);
    }

    public static function update($pdo, $id, $name, $role) {
        $stmt = $pdo->prepare("UPDATE medewerkers SET naam = ?, rol = ? WHERE id = ?");
        $stmt->execute([$name, $role, $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM medewerkers WHERE id = ?");
        $stmt->execute([$id]);
    }
}