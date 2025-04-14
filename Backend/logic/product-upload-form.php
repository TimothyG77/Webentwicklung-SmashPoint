<?php
header("Content-Type: application/json");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

require_once '../config/dbaccess.php';

$name = $_POST['product_name'] ?? '';
$description = $_POST['product_description'] ?? '';
$price = $_POST['price'] ?? 0.0;
$category = $_POST['category'] ?? '';
$picture = $_FILES['product_picture'];

if (!$name || !$description || !$price || !$category || !$picture) {
    echo json_encode(['success' => false, 'message' => 'Bitte alle Felder ausfüllen.']);
    exit;
}

// Bild speichern
$uploadDir = '../../Backend/productpictures/' . $category . '/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
$targetFile = $uploadDir . basename($picture['name']);

if (move_uploaded_file($picture['tmp_name'], $targetFile)) {
    $picturePath = str_replace('../../Backend/', '', $targetFile);

    $stmt = $conn->prepare("INSERT INTO produkte (product_name, product_description, price, product_picture, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $description, $price, $picturePath, $category);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Bild konnte nicht hochgeladen werden.']);
}

$conn->close();
