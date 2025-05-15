<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Ungültige Methode.']);
    exit;
}

require_once '../config/dbaccess.php';

$productID = $_POST['product_id'] ?? '';
$name = $_POST['product_name'] ?? '';
$desc = $_POST['product_description'] ?? '';
$price = $_POST['price'] ?? 0.0;

// Bild prüfen
$newImage = $_FILES['new_image'] ?? null;
$imagePath = null;

if ($newImage && $newImage['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../productpictures/';
    $fileName = uniqid() . '_' . basename($newImage['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($newImage['tmp_name'], $filePath)) {
        $imagePath = 'productpictures/' . $fileName;
    } else {
        echo json_encode(['success' => false, 'message' => 'Bild konnte nicht gespeichert werden.']);
        exit;
    }
}

if ($imagePath) {
    $stmt = $conn->prepare("UPDATE produkte SET product_name=?, product_description=?, price=?, product_picture=? WHERE ID=?");
    $stmt->bind_param("ssdsi", $name, $desc, $price, $imagePath, $productID);
} else {
    $stmt = $conn->prepare("UPDATE produkte SET product_name=?, product_description=?, price=? WHERE ID=?");
    $stmt->bind_param("ssdi", $name, $desc, $price, $productID);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Aktualisieren: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
