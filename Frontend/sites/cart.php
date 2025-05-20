<?php
session_start();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Warenkorb - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        //Globale Variable
        window.isUserLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
    </script>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2>Mein Warenkorb</h2>
    <div id="cartItems" class="row my-4"></div>

    <div class="text-end fw-bold fs-5">
        Gesamt: <span id="cartTotal">0,00 €</span>
    </div>

    <div class="text-end mt-4">
        <a href="checkout.php" class="btn btn-success" id="checkoutBtn" style="display: none;">Zur Kasse</a>
    </div>
</div>

<?php include('footer.php'); ?>

<!-- SCRIPTS -->
<script src="../js/cart.js"></script>
<script src="../js/cart-utils.js"></script>
<script src="../js/product-link.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.isUserLoggedIn) {
            loadCartFromDatabase();
        } else {
            updateCartCount(); // Holt Anzahl + zeigt Button
        }
    });
</script>

</body>
</html>
