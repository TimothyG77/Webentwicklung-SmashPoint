<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

require_once '../../Backend/config/dbaccess.php';
$result = $conn->query("SELECT ID, product_name, price, product_picture FROM produkte ORDER BY RAND()");
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$chunks = array_chunk($products, 3); // Die Produkte unterteilen in Gruppen zu je 3 Stück.
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../res/css/style.css"> 
</head>
<body>

<?php include 'header.php'; ?>

<?php
if (isset($_GET['login']) && $_GET['login'] === 'success' && isset($_SESSION['user'])) {
    $username = htmlspecialchars($_SESSION['user']);
    echo '<div class="alert alert-success text-center mt-4" role="alert">
    Login war erfolgreich! Willkommen zurück, <strong>' . $username . '</strong>!
    </div>';
}
?>

<div class="container mt-4">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <?php foreach ($chunks as $index => $chunk): ?>
            <!--Markiert das erste Element als aktiv, damit Karussel startet.-->
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"> 
                    <div class="row">
                        <?php foreach ($chunk as $product): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <a href="#" class="text-decoration-none product-link" data-id="<?= $product['ID'] ?>">
                                        <img src="../../Backend/<?= htmlspecialchars($product['product_picture']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>">
                                    </a>
                                    <div class="card-body d-flex flex-column text-center">
                                        <h5 class="card-title">
                                            <a href="#" class="text-decoration-none text-dark product-link" data-id="<?= $product['ID'] ?>">
                                                <?= htmlspecialchars($product['product_name']) ?>
                                            </a>
                                        </h5>
                                        <p class="card-text"><strong><?= number_format($product['price'], 2, ',', '.') ?> €</strong></p>
                                        <div class="mt-auto">
                                            <button class="btn btn-success add-to-cart-btn" data-id="<?= $product['ID'] ?>">In den Warenkorb</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="../js/cart-utils.js"></script>
<script src="../js/product-link.js"></script>

<script>
$(document).ready(function () {
    $(document).on("click", ".add-to-cart-btn", function () { // Gehört zum Button weiter oben 
        // Sobald ein Button "In den Warenkorb" geklickt wird, wird die Produkt-ID geholt und die Funktion addToCart() gerufen.
        const productId = Number($(this).data("id"));
        addToCart(productId);
    });

    if (window.isUserLoggedIn) {
        loadCartFromDatabase(); // beim Seitenladen aus DB mit AJAX in cart-utils.js
    } else {
        updateCartCount(); // nur localStorage (Gast)
    }
});
</script>

</body>
</html>
