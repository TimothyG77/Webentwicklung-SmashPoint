<?php
header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit;
}

require_once '../config/dbaccess.php';

$userID = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode(['success' => false, 'message' => 'Ungültige Methode.']);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Ungültige JSON-Daten.']);
    exit;
}

// Felder extrahieren
$salutation   = $data['salutation'] ?? '';
$firstname    = $data['firstname'] ?? '';
$lastname     = $data['lastname'] ?? '';
$address      = $data['address'] ?? '';
$postal_code  = $data['postal_code'] ?? '';
$city         = $data['city'] ?? '';
$email        = $data['email'] ?? '';
$username     = $data['username'] ?? '';

// Serverseitige Validierung
if (strlen($username) < 4) {
    echo json_encode(['success' => false, 'message' => 'Benutzername muss mindestens 4 Zeichen lang sein.']);
    exit;
}

if (!preg_match('/^\d{4,5}$/', $postal_code)) {
    echo json_encode(['success' => false, 'message' => 'PLZ muss 4 oder 5 Ziffern enthalten.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Ungültige E-Mail-Adresse.']);
    exit;
}


$stmt = $conn->prepare("UPDATE User SET salutation=?, firstname=?, lastname=?, address=?, postal_code=?, city=?, email=?, username=? WHERE ID=?");
$stmt->bind_param("ssssisssi", $salutation, $firstname, $lastname, $address, $postal_code, $city, $email, $username, $userID);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Profil erfolgreich aktualisiert.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
