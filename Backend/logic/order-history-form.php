<?php
session_start();
// Antwortet im JSON Format zurück
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// SIcherheitsmaßnahme wenn ein User nicht eingeloggt ist, dass ein leeres Array zurückgegeben wird
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userID = $_SESSION['user_id'];

// Holt alle Bestellungen aus der Tabelle orders und die neusten Bestellungen werden als Erstes angezeigt (DESC)
$stmt = $conn->prepare("
    SELECT 
        o.order_id,
        o.order_date,
        o.total_price,
        o.status,
        CONCAT(u.address, ', ', u.postal_code, ' ', u.city) AS shipping_adress
    FROM orders o
    JOIN user u ON o.user_id = u.ID
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

// Die gefilterten Daten werden in dem orders Array gespeichert
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Die Daten werden gesendet als JSON Daten, kann man mit F12 beobachten
echo json_encode($orders);

$stmt->close();
$conn->close();
