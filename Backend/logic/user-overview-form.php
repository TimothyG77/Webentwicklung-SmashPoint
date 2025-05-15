<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// Nur Admin darf Zugriff haben
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

// Nur wenn ?toggle gesetzt ist, wird die Aktion ausgeführt
if (!isset($_GET['toggle'])) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Anfrage.']);
    exit;
}

// JSON-Daten einlesen
$input = json_decode(file_get_contents("php://input"), true);
$userID = intval($input['id'] ?? 0);
$action = $input['action'] ?? '';

// Validierung
if (!$userID || !in_array($action, ['activate', 'deactivate'])) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Daten übermittelt.']);
    exit;
}

$newStatus = $action === 'activate' ? 'aktiv' : 'inaktiv';

// Update in der Datenbank
$stmt = $conn->prepare("UPDATE User SET status = ? WHERE ID = ?");
$stmt->bind_param("si", $newStatus, $userID);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Aktualisieren: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
