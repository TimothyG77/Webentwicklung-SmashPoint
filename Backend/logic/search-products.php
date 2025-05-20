<?php
require_once '../config/dbaccess.php';

header('Content-Type: application/json'); 

$term = $_GET['term'] ?? ''; //Holt den Suchbegriff aus der URL mit dem Wert term.
$term = trim($term);

if (strlen($term) < 1) {
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT ID, product_name FROM produkte WHERE product_name LIKE CONCAT('%', ?, '%') LIMIT 10");
$stmt->bind_param("s", $term); //Die Abfrage als String einbinden -> sicher gegen SQL Injection
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row; //Daten werden ins Array gespeichert
}

echo json_encode($products); //Gibt das Array als JSON Text zurück

$stmt->close();
$conn->close();
