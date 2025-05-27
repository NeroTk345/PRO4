<!DOCTYPE html>
<html>
<head>
    <title>Medewerker Overzicht</title>
    <style>
        table { border-collapse: collapse; width: 60%; margin: 40px auto;}
        th, td { border: 1px solid #ccc; padding: 8px 16px; }
        th { background: #eab308; }
        td, th { text-align: center; }
        a, button { color: #eab308; text-decoration: none; background: none; border: none; cursor: pointer; }
        .add-form, .edit-form { margin: 30px auto; width: 60%; text-align: center; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Medewerker Overzicht</h1>
    <!-- Add form -->
    <form class="add-form" method="post">
        <input type="text" name="name" placeholder="Naam" required>
        <select name="role">
            <option value="Manager">Manager</option>
            <option value="Medewerker">Medewerker</option>
        </select>
        <button type="submit" name="add">Toevoegen</button>
    </form>
    <?php if (isset($error)): ?>
        <div style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Rol</th>
            <th>Acties</th>
        </tr>
        <?php foreach ($employees as $employee): ?>
        <tr>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $employee->id): ?>
                <!-- Inline edit form -->
                <form method="post" class="edit-form">
                    <td><?= htmlspecialchars($employee->id) ?></td>
                    <td><input type="text" name="edit_name" value="<?= htmlspecialchars($employee->name) ?>" required></td>
                    <td>
                        <select name="edit_role">
                            <option value="Manager" <?= $employee->role == 'Manager' ? 'selected' : '' ?>>Manager</option>
                            <option value="Medewerker" <?= $employee->role == 'Medewerker' ? 'selected' : '' ?>>Medewerker</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="edit_id" value="<?= $employee->id ?>">
                        <button type="submit">Opslaan</button>
                        <a href="medewerker.php">Annuleren</a>
                    </td>
                </form>
            <?php else: ?>
                <td><?= htmlspecialchars($employee->id) ?></td>
                <td><?= htmlspecialchars($employee->name) ?></td>
                <td><?= htmlspecialchars($employee->role) ?></td>
                <td>
                    <a href="medewerker.php?edit=<?= $employee->id ?>">Bewerken</a> |
                    <a href="medewerker.php?delete=<?= $employee->id ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
    <div style="text-align:center; margin-top: 1em;">
        <a href="/medewerker/public/logout.php">Uitloggen</a>
    </div>
</body>
</html>