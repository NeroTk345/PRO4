<?php
session_start();
unset($_SESSION['medewerker_logged_in']);
session_destroy();
header('Location: /pages/home.php');
exit;