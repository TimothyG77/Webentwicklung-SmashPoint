<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../Backend/config/dbaccess.php';

// Zur Sicherheit Produkt-ID Abfragen 
$productId = $_GET['id'] ?? null;
if (!$productId) {
    echo "Ungültige Produkt-ID.";
    exit;
}

// Produkt aus DB laden und unten im HTML ausprinten
$stmt = $conn->prepare("SELECT product_name, product_description, price, product_picture FROM produkte WHERE ID = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->bind_result($name, $description, $price, $picture);
if (!$stmt->fetch()) {
    echo "Produkt mit der ID $productId wurde nicht gefunden.";
    exit;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkt bearbeiten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="container mt-5">
<?php include 'header.php' ?>


<h2>Produkt bearbeiten</h2>

<form id="editProductForm" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">

    <div class="mb-3">
        <label class="form-label">Aktuelles Produktbild</label><br>
        <img id="product-image-preview" src="../../Backend/<?= htmlspecialchars($picture) ?>" alt="Produktbild" style="max-height: 200px; display:block;">
        <input type="file" name="new_image" class="form-control mt-2" accept="image/*">
    </div>

    <div class="mb-3">
        <label class="form-label">Produktname</label>
        <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Beschreibung</label>
        <textarea name="product_description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Preis (€)</label>
        <input type="number" name="price" class="form-control" step="0.01" value="<?= htmlspecialchars($price) ?>" required>
    </div>

    <div id="update-success" class="alert alert-success d-none"></div>
    <div id="update-error" class="alert alert-danger d-none"></div>

    <button type="submit" class="btn btn-warning">Produkt aktualisieren</button>
</form>

<script src="../js/product-edit.js"></script>
</body>
</html>
