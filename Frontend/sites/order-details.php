<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

$orderID = intval($_GET['order_id']);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestelldetails - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Bestelldetails – Bestellung #<?= $orderID ?></h2>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Produkt</th>
                <th>Menge</th>
                <th>Einzelpreis</th>
                <th>Gesamt</th>
            </tr>
        </thead>
        <tbody id="orderDetailsBody">
            <tr><td colspan="4">Lade Bestelldetails ...</td></tr>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="order-history.php" class="btn btn-secondary">Zur Bestellübersicht</a>
    </div>
</div>

<script>
    const ORDER_ID = <?= $orderID ?>;
</script>
<script src="../js/order-details.js"></script>
<?php include('footer.php'); ?>
</body>
</html>
