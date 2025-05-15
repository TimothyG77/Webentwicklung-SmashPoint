<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// Warenkorb aus POST-Daten holen
$input = json_decode(file_get_contents("php://input"), true);
$cartItems = $input['cart'] ?? [];

if (empty($cartItems)) {
    echo json_encode([]);
    exit;
}

// IDs extrahieren
$productIds = array_map(function($item) {
    if (is_array($item) && isset($item['id'])) {
        return intval($item['id']);
    }
    return intval($item); 
}, $cartItems);


if (empty($productIds)) {
    echo json_encode([]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$types = str_repeat('i', count($productIds));

$stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE ID IN ($placeholders)");
$stmt->bind_param($types, ...$productIds);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>