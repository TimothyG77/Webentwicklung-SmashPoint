<?php
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

$category = $_GET['category'] ?? '';

// Die Produkte je nach Kategorie laden aus der Datenbank von der Tabelle produkte
if ($category) {
    $stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE category = ?");
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte");
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $row['price'] = floatval($row['price']); 
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
