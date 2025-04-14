<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkt hochladen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="container mt-5">

    <h2>Neues Produkt hochladen</h2>

    <form id="productUploadForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Produktname</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>
        <div class="mb-3">
            <label for="product_description" class="form-label">Beschreibung</label>
            <textarea class="form-control" name="product_description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Preis (€)</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Kategorie</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Bitte wählen...</option>
                <option value="Bekleidung-Herren">Bekleidung (Herren)</option>
                <option value="Bekleidung-Damen">Bekleidung (Damen)</option>
                <option value="Griffbaender">Griffbänder</option>
                <option value="Saiten">Saiten</option>
                <option value="Schlaeger">Schlaeger</option>
                <option value="Schuhe">Schuhe</option>
                <option value="Taschen">Taschen</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="product_picture" class="form-label">Bild hochladen</label>
            <input type="file" class="form-control" name="product_picture" accept="image/*" required>
        </div>

        <div id="upload-success" class="alert alert-success d-none"></div>
        <div id="upload-error" class="alert alert-danger d-none"></div>

        <button type="submit" class="btn btn-primary">Produkt hochladen</button>
    </form>

    <script src="../js/product-upload.js"></script>
</body>
</html>
