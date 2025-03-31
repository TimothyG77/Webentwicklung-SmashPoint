<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../config/dbaccess.php'; // stellt $conn bereit

    $salutation   = $_POST['anrede'];
    $firstname    = $_POST['vorname'];
    $lastname     = $_POST['nachname'];
    $address      = $_POST['adresse'];
    $postal_code  = $_POST['plz'];
    $city         = $_POST['ort'];
    $email        = $_POST['email'];
    $username     = $_POST['benutzername'];
    $password     = $_POST['password'];
    $confirm      = $_POST['confirm_password'];
    $role         = 'user';
    $status       = 'aktiv';

      // Passwörter stimmen nicht überein:
    if ($password !== $confirm) {
        header("Location: ../../Frontend/sites/register.php?error=password_error");
        exit;
    }

    // Benutzername existiert schon?
    $checkUser = $conn->prepare("SELECT ID FROM User WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        
        header("Location: ../../Frontend/sites/register.php?error=user_exists_error");
        exit;
    }

    $sql = "INSERT INTO User (salutation, firstname, lastname, address, postal_code, city, email, username, password, role, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // sicher!


    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "ssssissssss", 
            $salutation, $firstname, $lastname, $address, $postal_code, $city,
            $email, $username, $password, $role, $status
        );

        if ($stmt->execute()) {
            $_SESSION['user'] = $username;

             // Pop-up Nachricht und Weiterleitung zu index.php
            header("Location: ../../Frontend/sites/index.php?registration_success=1");
            exit;

        } else {
            echo "Fehler beim Speichern: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Fehler beim Vorbereiten der Datenbankabfrage: " . $conn->error;
    }

    $conn->close();
}
?>
