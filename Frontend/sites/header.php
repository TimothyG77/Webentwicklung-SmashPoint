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
    <link rel="stylesheet" href="styles.css"> 

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        
        <a class="navbar-brand" href="index.php">
            <img src="logo.png" alt="Webshop Logo" width="120">
        </a>

        
        <form class="d-flex mx-auto" action="search.php" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Produkte suchen..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Suchen</button>
        </form>

        
        <div class="d-flex">
            <a href="cart.php" class="btn btn-outline-dark me-2">
                🛒 Warenkorb
                <span class="badge bg-danger" id="cart-count">0</span>
            </a>
            <a href="profile.php" class="btn btn-outline-dark">👤 Profil</a>
        </div>
    </div>
</nav>

</body>
</html>