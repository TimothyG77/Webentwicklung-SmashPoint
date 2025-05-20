<?php
session_start();
header('Content-Type: application/json'); //Antwort wird als JSON zurückgeschickt
require_once '../config/dbaccess.php';

// Warenkorb aus POST-Daten holen
$input = json_decode(file_get_contents("php://input"), true);
$cartItems = $input['cart'] ?? [];

if (empty($cartItems)) { //Wenn de Warenkorb leer ist, gibt der Server ein leeres Array zurück
    echo json_encode([]);
    exit;
}

// IDs extrahieren, indem cartItems in ein reines Array mit Produkt-IDs umgewandelt wird
$productIds = array_map(function($item) {
    if (is_array($item) && isset($item['id'])) {
        return intval($item['id']);
    }
    return intval($item); 
}, $cartItems);


if (empty($productIds)) {
    echo json_encode([]); //Sicherheitshalber nochmal überprüfen, ob überhaupt IDs vorhanden sind.
    exit;
}

$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$types = str_repeat('i', count($productIds));

$stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE ID IN ($placeholders)");
$stmt->bind_param($types, ...$productIds);
$stmt->execute();
$result = $stmt->get_result();

$products = []; // Wird in der fetch-Anfrage in cart.js verwendet
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products); // Zurücksenden die JSON Datei

$stmt->close();
$conn->close();
?>