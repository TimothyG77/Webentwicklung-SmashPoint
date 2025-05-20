<?php
session_start();

// Nur Admins dürfen zugreifen
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gutscheine verwalten - SmashPoint</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold">Gutscheine verwalten</h2>

    
    <div id="feedback" class="alert d-none text-center"></div>

    <!-- Button zum Generieren -->
    <div class="d-flex justify-content-end mb-3">
        <button id="generateVoucherBtn" class="btn btn-success">Gutschein generieren</button>
    </div>

    <!-- Tabelle -->
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Code</th>
                    <th>Wert (%)</th>
                    <th>Erstellt am</th>
                    <th>Ablaufdatum</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="voucherTable">
                <tr><td colspan="5">Lade Gutscheine...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
<script src="../js/voucher.js"></script>
</body>
</html>
