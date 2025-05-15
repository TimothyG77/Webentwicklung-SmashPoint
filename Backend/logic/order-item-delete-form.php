<?php
session_start();
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

// Zugriff prüfen
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Ungültige Methode.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$itemID = intval($data['item_id'] ?? 0);

if (!$itemID) {
    echo json_encode(['success' => false, 'message' => 'Ungültige Item-ID.']);
    exit;
}

// 🔍 Hole zugehörige order_id
$stmt = $conn->prepare("SELECT order_id FROM order_items WHERE item_id = ?");
$stmt->bind_param("i", $itemID);
$stmt->execute();
$stmt->bind_result($orderID);
$stmt->fetch();
$stmt->close();

if (!$orderID) {
    echo json_encode(['success' => false, 'message' => 'Zuordnung zur Bestellung nicht gefunden.']);
    exit;
}

//Position löschen
$stmt = $conn->prepare("DELETE FROM order_items WHERE item_id = ?");
$stmt->bind_param("i", $itemID);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

//Gesamtpreis neu berechnen
$stmt = $conn->prepare("SELECT SUM(quantity * price_each) FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$stmt->bind_result($newTotal);
$stmt->fetch();
$stmt->close();

$newTotal = $newTotal ?: 0.00;

//Gesamtpreis in orders-Tabelle aktualisieren
$stmt = $conn->prepare("UPDATE orders SET total_price = ? WHERE order_id = ?");
$stmt->bind_param("di", $newTotal, $orderID);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => true, 'new_total' => $newTotal]);
$conn->close();
exit;
