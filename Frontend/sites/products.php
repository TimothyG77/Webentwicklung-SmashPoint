<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produkte</h2>

        <?php if ($isAdmin): ?>
            <div class="d-flex gap-2">
                <a href="product-upload.php" class="btn btn-outline-warning">Produkte hochladen</a>
                <a href="product-delete.php" class="btn btn-outline-danger">Produkte löschen</a>
            </div>
        <?php endif; ?>
    </div>

    <select id="categorySelect" class="form-select mb-3">
        <option value="">Alle</option>
        <option value="Bekleidung-Herren">Bekleidung (Herren)</option>
        <option value="Bekleidung-Damen">Bekleidung (Damen)</option>
        <option value="Griffbaender">Griffbänder</option>
        <option value="Baelle">Bälle</option>
        <option value="Schuhe">Schuhe</option>
        <option value="Saiten">Saiten</option>
        <option value="Schlaeger">Schläger</option>
        <option value="Taschen">Taschen</option>
    </select>

    <div id="productList" class="row" data-isadmin="<?= isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'true' : 'false' ?>"></div>

</div>

<?php include('footer.php'); ?>
<script src="../js/products.js"></script>
</body>
</html>
