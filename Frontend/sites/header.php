<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<script>
    window.isUserLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmashPoint</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../res/css/style.css"> 
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            <img src="../res/img/SmashPointLogo.png" alt="Webshop Logo" width="120">
        </a>

        <div class="position-relative w-50 mx-auto">
            <input class="form-control me-2" type="search" id="productSearch" placeholder="Produkte suchen...">
            <ul class="list-group position-absolute w-100 d-none" id="searchResults" style="z-index: 9999;"></ul>
        </div>

        <ul class="navbar-nav flex-row ms-auto">
            <li class="nav-item me-2">
                <a href="index.php" class="btn btn-outline-dark">Home</a>
            </li>
            <li class="nav-item me-2">
                <a href="products.php" class="btn btn-outline-dark">Produkte</a>
            </li>
            <li class="nav-item me-2">
                <a href="cart.php" class="btn btn-outline-dark">
                    Warenkorb
                    <span class="badge bg-danger" id="cart-count">0</span>
                </a>
            </li>
            <li class="nav-item me-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profile.php" class="btn btn-outline-dark">Mein Konto</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-dark">Login</a>
                <?php endif; ?>
            </li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li class="nav-item me-2">
                    <a href="voucher.php" class="btn btn-outline-primary">Gutscheine verwalten</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<!-- Warenkorb-Zähler -->
<script src="../js/cart-utils.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", updateCartCount);
</script>

<!-- Suchvorschläge -->
<script src="../js/search-suggestions.js"></script>
