<?php
// Ist die Datei wo alle Bestellungen gezeigt werden als User
// Zugriffskontrolle -> Zur Sicherheit
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellübersicht - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Meine Bestellübersicht</h2>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Bestellnr.</th>
                <th>Datum</th>
                <th>Preis</th>
                <th>Status</th>
                <th>Versandadresse</th>
                <th>Rechnung</th>
            </tr>
        </thead>
        <tbody id="orderHistoryBody">
            <tr><td colspan="5">Lade Bestellungen ...</td></tr>
        </tbody>
    </table>
</div>

<script src="../js/order-history.js"></script>
<?php include('footer.php'); ?>
</body>
</html>
