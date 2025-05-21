<?php
session_start();
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

// Sicherheitsmaßnahme
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

// OrderID wird aus der URL geholt und in einem Integer umgewandelt
$orderID = intval($_GET['order_id']);

// Die userID wird aus dem SESSION Array gelesen
$userID = $_SESSION['user_id'];

// Ladet die Bestelldaten sowie Kundendaten
$stmt = $conn->prepare("
    SELECT o.order_id, o.order_date, o.invoice_number, o.total_price, o.voucher_percent,
           u.firstname, u.lastname, u.address, u.postal_code, u.city, u.email
    FROM orders o
    JOIN user u ON o.user_id = u.ID
    WHERE o.order_id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $orderID, $userID);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

// Sicherheitsmaßnahme ob auch die Bestellung existiert
if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Bestellung nicht gefunden.']);
    exit;
}

// Rechnungsnummer generieren wenn nicht vorhanden und in der DB speichern in der Spalte invoice_number
if (empty($order['invoice_number'])) {
    $invoiceNumber = $orderID . '-' . date("Ymd");
    $stmt = $conn->prepare("UPDATE orders SET invoice_number = ? WHERE order_id = ?");
    $stmt->bind_param("si", $invoiceNumber, $orderID);
    $stmt->execute();
    $stmt->close();
    $order['invoice_number'] = $invoiceNumber;
}

$stmt = $conn->prepare("
    SELECT p.product_name, oi.quantity, oi.price_each
    FROM order_items oi
    JOIN produkte p ON oi.product_id = p.ID
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

// Die gefilterten Daten werden im items-Array gespeichert und im JSON Format gesendet 
$items = [];
while ($row = $result->fetch_assoc()) {
    $row['price_each'] = (float)$row['price_each'];
    $items[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode([
    'success' => true, // Hier haben wir den success-Wert (true) für den AJAX Call
    'order' => $order, // IM AJAX Call das "data.order"
    'items' => $items // IM AJAX Call das "data.items"
]);
exit;
