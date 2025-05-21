<?php
session_start();

// Sicherheitsmaßnahme
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

// Holt sich die orderID aus der URL mit der GET-Methode
$orderID = intval($_GET['order_id']);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnung anzeigen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <!--Der Druckstil-->
    <style>
        @media print { .no-print { display: none; } }
        .signature { margin-top: 60px; }
    </style>
</head>
<body>

<div class="no-print">
    <?php include('header.php'); ?>
</div>

<div class="container mt-5" id="invoiceContainer">
    <!--Druckknopf-->
    <div class="text-end no-print">
        <button class="btn btn-outline-primary" onclick="window.print()">Drucken</button>
    </div>
    <div id="invoiceContent">Lade Rechnung ...</div>
</div>

<script>
    const ORDER_ID = <?= $orderID ?>;
</script>
<script src="../js/invoice.js"></script>

<?php include('footer.php'); ?>
</body>
</html>
