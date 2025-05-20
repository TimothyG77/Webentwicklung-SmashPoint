
<?php
header('Content-Type: application/json');
session_start();

// Zugriffsschutz
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Ungültige Anfragemethode.']);
    exit;
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Nicht autorisiert.']);
    exit;
}

require_once '../config/dbaccess.php';

// Liest die JSON Daten
$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['id'] ?? null;

// Sicherheitsmaßnahme wenn ein Produkt keine ID zugewiesen ist
if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Produkt-ID fehlt.']);
    exit;
}

// Produktbild vorher löschen in unserem Datenverzeichnis mit unlink
$stmt = $conn->prepare("SELECT product_picture FROM produkte WHERE ID = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->bind_result($picturePath);
if ($stmt->fetch()) {
    $fullPath = '../../Backend/' . $picturePath;
    if (file_exists($fullPath)) {
        unlink($fullPath); // Bild löschen
    }
}
$stmt->close();

// Produkt aus Datenbank löschen
$stmt = $conn->prepare("DELETE FROM produkte WHERE ID = ?");
$stmt->bind_param("i", $productId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Löschen.']);
}

$stmt->close();
$conn->close();
?>
