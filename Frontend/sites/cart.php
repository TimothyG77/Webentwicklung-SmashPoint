<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Warenkorb - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>🛒 Mein Warenkorb</h2>
    <div id="cartItems" class="row my-4"></div>
    <div class="text-end fw-bold fs-5">Gesamt: <span id="cartTotal">0,00 €</span></div>
</div>

<script src="../js/cart.js"></script>
</body>
</html>
