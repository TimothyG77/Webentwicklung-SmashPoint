<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Webshop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../res/css/style.css"> 
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        
        <a class="navbar-brand" href="index.php">
            <img src="../res/img/SmashPointLogo.png" alt="Webshop Logo" width="120">
        </a>

        <form class="d-flex mx-auto" action="search.php" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Produkte suchen..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Suchen</button>
        </form>

        <ul class="navbar-nav flex-row">
            <li class="nav-item me-2">
                <a href="index.php" class="btn btn-outline-dark">Home</a>
            </li>
            <li class="nav-item me-2">
                <a href="products.php" class="btn btn-outline-dark">Produkte</a>
            </li>
            <li class="nav-item me-2">
                <a href="cart.php" class="btn btn-outline-dark">
                    🛒 Warenkorb
                    <span class="badge bg-danger" id="cart-count">0</span>
                </a>
            </li>
            <li class="nav-item me-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="profile.php" class="btn btn-outline-dark">👤 Mein Konto</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-dark">👤 Login</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>

<script src="../js/cart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const total = cart.reduce((sum, p) => sum + (p.qty || 1), 0);
        document.getElementById("cart-count").textContent = total;
});
</script>

</body>
</html>
