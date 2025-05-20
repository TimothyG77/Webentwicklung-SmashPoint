<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

if (!isset($_SESSION['user_id'])) { // Wenn niemand eingeloggt ist, gibt es keinen user_id in der SESSION
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id']; // Hier wird der aktuelle User mit der ID in der SESSION gespeichert.

$stmt = $conn->prepare("SELECT product_id, quantity FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result(); // Datenbankabfrage um Produkte zu holen

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = [
        'id' => (int)$row['product_id'],
        'qty' => (int)$row['quantity'] // Datenstruktur wird festgelegt fürs JSON Format
    ];
}

echo json_encode($cart);
$stmt->close();
$conn->close();
