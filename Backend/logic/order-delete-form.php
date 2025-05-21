<?php
session_start();
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

//Zugriffskontrolle: Nur Admin darf löschen
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

//Nur DELETE-Requests erlauben
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Ungültige Methode.']);
    exit;
}

//JSON-Daten einlesen und Bestell-ID prüfen
$input = json_decode(file_get_contents("php://input"), true);
$orderID = intval($input['order_id'] ?? 0);

if (!$orderID) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Bestell-ID.']);
    exit;
}

//Zuerst Positionen aus order_items löschen
$stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$stmt->close();

//Dann Bestellung aus orders löschen
$stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $orderID);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen der Bestellung.']);
}

$stmt->close();
$conn->close();
exit;
