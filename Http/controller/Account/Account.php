<?php
// Gebruik de bestaande database class en config
require_once __DIR__ . '/../../../Core/functions.php';
require_once base_path('Core/Database.php');
$config = require base_path('config.php');

use Core\Database;

// Check if a session is already active before starting one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Maak databaseverbinding via de Database class
$db = new Database($config['database'], $config['database']['username'], $config['database']['password']);

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

// Haal gebruikersnaam/email uit sessie
$email = $_SESSION['user']['email'] ?? 'Niet beschikbaar';

// Haal de gebruiker op uit de database
$user = $db->query('SELECT Gebruikersnaam FROM Gebruiker WHERE Gebruikersnaam = :email', [
    'email' => $email
])->find();

$gebruikersnaam = $user['Gebruikersnaam'] ?? 'Onbekend';



// Sluit de databaseverbinding
// $conn->close(); // Niet nodig, wordt beheerd door de Database class
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="<?php echo base_path('public/css/account.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .info {
            text-align: center;
            margin-top: 50px;
        }
        .info img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
        }
        .info h2 {
            color: #333;
        }
        .info p {
            color: #555;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container h3 {
            color: #444;
        }
    </style>
</head>
<body>
<br>

    <div class="info">
        <img src="afbeeldingen/download.png" alt="avatar">
        <h2>Welkom, <span id="naamText"><?php echo htmlspecialchars($gebruikersnaam); ?></span>!</h2>
        <p><strong>Email:</strong> <span id="emailText"><?php echo htmlspecialchars($email); ?></span></p>
        <a href="logout.php">Uitloggen</a><br><br>
        <button id="veranderKnop">Verander informatie</button>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="witVlak">
                    <img src="afbeeldingen/DSC_1612.jpg" alt="Hoi">
                    <h2><span id="naamText"><?php echo htmlspecialchars($gebruikersnaam); ?></span></h2>
                    <strong><p>Email</p></strong>
                    <p><span id="emailText"><?php echo htmlspecialchars($email); ?></span></p>
                </div>
            </div>
            <div class="col-9">
                <div class="witVlak">
                    <hr/><br><br>
                    <ul class="education"></ul>
                    <a href="../php/index.php">Home pagina</a><br>
                    <a href="lessen.php">Lessen pagina</a>
                </div>
            </div>
        </div>
    </div>

    <form id="editForm" method="POST" action="update.php" style="display: none;">
        <br><label for="naam">Naam:</label>
        <input type="text" id="naamInput" name="naam" value="<?php echo htmlspecialchars($gebruikersnaam); ?>">

        <label for="email">Email:</label>
        <input type="email" id="emailInput" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <button type="submit">Opslaan</button>
    </form>

    <script>
        document.getElementById("veranderKnop").addEventListener("click", function() {
            document.getElementById("editForm").style.display = "block";
        });
    </script>

</body>
</html>
