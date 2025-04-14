<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// Produkt-IDs aus POST-Daten holen (statt aus $_SESSION)
$input = json_decode(file_get_contents("php://input"), true);
$cart = array_map('intval', $input['cart'] ?? []);

if (empty($cart)) {
    echo json_encode([]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($cart), '?'));
$types = str_repeat('i', count($cart));

$stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE ID IN ($placeholders)");
$stmt->bind_param($types, ...$cart);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
