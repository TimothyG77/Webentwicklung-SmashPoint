<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produktdetails</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5" id="productDetailContainer">
    <!-- Hier werden die Produktdetails per AJAX eingefügt -->
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Laden...</span>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../js/cart-utils.js"></script> <!-- Immer zuerst! -->
<script src="../js/product-detail.js"></script> <!-- Danach! -->


</body>
</html>
