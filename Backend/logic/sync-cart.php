<?php
session_start();
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit; // Nur eingeloggte Nutzer können ihren Warenkorb abspeichern.
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$cart = $data['cart'] ?? []; // Holt den JSON-Text aus der Anfrage und wandelt es in ein PHP-Array um.

// Immer erst alte Cart-Einträge löschen
$stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();

// Wenn leer, einfach zurückmelden
if (empty($cart)) {
    echo json_encode(['success' => true, 'message' => 'Warenkorb geleert.']);
    $conn->close();
    exit;
}

// Neue Cart-Einträge einfügen
$stmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
foreach ($cart as $item) {
    $productId = intval($item['id']);
    $qty = intval($item['qty']);
    $stmt->bind_param("iii", $userId, $productId, $qty);
    $stmt->execute();
}
$stmt->close();

echo json_encode(['success' => true, 'message' => 'Warenkorb erfolgreich synchronisiert.']);
$conn->close();
