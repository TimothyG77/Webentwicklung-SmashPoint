<?php
$host = "localhost";
$dbname = "smashpoint";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
