<?php
ini_set('display_errors', 1); // Ist für das Debuggen i PHP, aktiviert die Anzeige von Laufzeit-Fehlern im Browser
ini_set('display_startup_errors', 1); // Anzeige von Fehlern beim Start von PHP
error_reporting(E_ALL); // Zeigt alle Arten vonn Fehlern an

header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/dbaccess.php';

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Ungültige JSON-Daten.']);
        exit;
    }

    // Werte extrahieren
    $salutation = $input['anrede'] ?? '';
    $firstname = $input['vorname'] ?? '';
    $lastname = $input['nachname'] ?? '';
    $address = $input['adresse'] ?? '';
    $postal_code = $input['plz'] ?? '';
    $city = $input['ort'] ?? '';
    $email = $input['email'] ?? '';
    $username = $input['benutzername'] ?? '';
    $password = $input['password'] ?? '';
    $confirm = $input['confirm_password'] ?? '';
    $role = 'user';
    $status = 'aktiv';

    // Wenn beide Passworteingaben nicht übereinstimmen
    if ($password !== $confirm) {
        echo json_encode(['success' => false, 'message' => 'Passwörter stimmen nicht überein.']);
        exit;
    }

    $checkUser = $conn->prepare("SELECT ID FROM User WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $checkUser->store_result();

    if ($checkUser->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Benutzername ist bereits vergeben.']);
        exit;
    }
    $checkUser->close();

    
    // Passwörter werden gehasht
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Daten werden in die Datnebank eingetragen mit INSERT
    $stmt = $conn->prepare("INSERT INTO User (salutation, firstname, lastname, address, postal_code, city, email, username, password, role, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $salutation, $firstname, $lastname, $address, $postal_code, $city, $email, $username, $hashedPassword, $role, $status);

    if ($stmt->execute()) { // Der Username sowie die User-ID werden in die SESSION Variable gespeichert
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = $stmt->insert_id;
        echo json_encode(['success' => true]); // Success Antowrt hier
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
