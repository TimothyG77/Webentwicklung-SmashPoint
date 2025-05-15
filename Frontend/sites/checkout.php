<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Checkout - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Bestellübersicht</h2>

    <div id="checkoutItems" class="row mb-4"></div>

    <div class="mb-3">
        <label for="voucherCode" class="form-label">Gutscheincode (optional):</label>
        <div class="input-group">
            <input type="text" id="voucherCode" class="form-control" placeholder="z. B. AAAAA">
            <button id="applyVoucherBtn" class="btn btn-outline-primary">Einlösen</button>
        </div>
    </div>

    <div class="text-end fw-bold fs-5 mb-4">
        Gesamtbetrag: <span id="checkoutTotal">0,00 €</span>
    </div>

    <?php if ($isLoggedIn): ?>
        <div class="text-end">
            <button id="placeOrderBtn" class="btn btn-success">Bestellung abschicken</button>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            Du musst eingeloggt sein, um zu bestellen.
            <br><a href="register.php" class="btn btn-primary mt-2">Zur Registrierung</a>
        </div>
    <?php endif; ?>
</div>

<script src="../js/checkout.js"></script>
</body>
</html>   