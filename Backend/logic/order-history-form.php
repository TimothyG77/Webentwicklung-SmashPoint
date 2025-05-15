<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userID = $_SESSION['user_id'];

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

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);

$stmt->close();
$conn->close();
