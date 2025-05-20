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
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produkte</h2>

        <?php if ($isAdmin): ?>
            <div class="d-flex gap-2">
                <a href="product-upload.php" class="btn btn-outline-dark">Produkte hochladen</a>
                <a href="product-delete.php" class="btn btn-outline-dark">Produkte löschen</a>
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

    <div id="productList" class="row" data-isadmin="<?= $isAdmin ? 'true' : 'false' ?>"></div>

</div>

<?php include('footer.php'); ?>

<!-- SCRIPTS -->
<script src="../js/products.js"></script>
<script src="../js/cart-utils.js"></script>
<script src="../js/product-link.js"></script> 
</body>
</html>
