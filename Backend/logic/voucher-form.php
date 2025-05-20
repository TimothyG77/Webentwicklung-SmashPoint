<?php
session_start();
header("Content-Type: application/json");
require_once '../config/dbaccess.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!isset($input['generate'])) {
        echo json_encode(['success' => false, 'message' => 'Ungültige Anfrage.']);
        exit;
    }

    function generateCode($length = 5) { // Gutscheincode Generierung 5-stellig
        return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, $length);
    }

    $code = generateCode();
    $value = 15.00;
    $created = date("Y-m-d H:i:s");
    $expires = date("Y-m-d H:i:s", strtotime("+30 days"));
    $used = 0;

    $stmt = $conn->prepare("INSERT INTO vouchers (code, value, created_at, expires_at, used) VALUES (?, ?, ?, ?, ?)"); //Speicherung des Guttscheins in der Datenbank
    $stmt->bind_param("sdssi", $code, $value, $created, $expires, $used);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'code' => $code]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehler beim Einfügen des Gutscheins.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Gutscheine abrufen aus der Datenbank
    $result = $conn->query("SELECT code, value, created_at, expires_at, used FROM vouchers ORDER BY created_at DESC");
    $vouchers = [];

    while ($row = $result->fetch_assoc()) {
        $vouchers[] = $row;
    }

    echo json_encode($vouchers);
    $conn->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Ungültige Methode.']);
exit;
