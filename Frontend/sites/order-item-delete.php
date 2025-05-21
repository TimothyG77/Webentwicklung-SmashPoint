<?php
session_start();
require_once '../../Backend/config/dbaccess.php';

// Button -> Details, ist das bei der Benutzerübersicht, wenn man auf eine Bestellung eines anderen Users klickt als Admin
// Zugriffsschutz
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit;
}

// Die orderId wird aus der URL geholt, Verbindung zu order-history.js
$orderId = intval($_GET['order_id']);

// Die Daten werden aus der Tabelle order_items geholt und in $result gespeichert
$stmt = $conn->prepare("
    SELECT 
        oi.item_id, 
        oi.quantity, 
        oi.price_each, 
        p.product_picture
    FROM order_items oi
    LEFT JOIN produkte p ON oi.product_id = p.ID
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellpositionen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Produkte der Bestellung #<?= $orderId ?></h2>

    <div id="feedbackMessage" class="alert d-none text-center"></div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Produkt</th>
                <th>Menge</th>
                <th>Preis pro Stück</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            <!--Die einzelnen Produkte einer Bestellung werden als Tabelle ausgeprintet-->
            <?php while ($item = $result->fetch_assoc()): ?>
                <tr data-id="<?= $item['item_id'] ?>">
                    <td>
                        <?php if (!empty($item['product_picture'])): ?>
                            <img src="../../Backend/<?= htmlspecialchars($item['product_picture']) ?>" 
                                 alt="Produktbild" 
                                 style="height: 60px; object-fit: contain; display: block; margin: 0 auto;">
                        <?php else: ?>
                            <div class="text-muted">Kein Bild verfügbar</div>
                        <?php endif; ?>
                    </td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['price_each'], 2, ',', '.') ?> €</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger delete-item-btn">Entfernen</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="../js/order-item-delete.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>
