<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// SIcherheitsmaßnahme
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    echo json_encode([]);
    exit;
}

// Die orderID wird aus der URL gelesen und in eine Zahl umgewandelt
// Die userID wird aus der SESSION gelesen
$orderID = intval($_GET['order_id']);
$userID = $_SESSION['user_id'];

// Sicherheit indem man nur seine eigenen Bestellungen einsehen kann
$check = $conn->prepare("SELECT order_id FROM orders WHERE order_id = ? AND user_id = ?");
$check->bind_param("ii", $orderID, $userID);
$check->execute();
$check->store_result();

// Keine Daten zurück wenn orderID und userID nicht existieren
if ($check->num_rows === 0) {
    echo json_encode([]);
    exit;
}
$check->close();

// Die Produkte filtern aus der Datenbank
$stmt = $conn->prepare("
    SELECT oi.quantity, oi.price_each, p.product_name, p.product_picture 
    FROM order_items oi 
    JOIN produkte p ON oi.product_id = p.ID 
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

// Die gefilterten Produkte derjenigen Bestellung(orderID) wird ins Array items gespeichert und im JSON Format ans Frontend geschickt
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

$stmt->close();
$conn->close();
