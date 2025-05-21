<?php
session_start();
require_once '../../Backend/config/dbaccess.php';

// Wenn man auf eine Bestellung eines anderen Users löschen will, da wo der Button Details und Löschen ist
// Zugriff prüfen
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin' || !isset($_GET['user_id'])) {
    header("Location: login.php");
    exit;
}

$targetUserId = intval($_GET['user_id']);

// Benutzerdaten laden
$stmt = $conn->prepare("SELECT firstname, lastname, email FROM user WHERE ID = ?");
$stmt->bind_param("i", $targetUserId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Bestellungen dieses Users abrufen
$stmt = $conn->prepare("SELECT order_id, order_date, total_price, status FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $targetUserId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellungen von <?= htmlspecialchars($user['firstname']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">
        Bestellungen von <?= htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']) ?>
        <small class="d-block text-muted"><?= htmlspecialchars($user['email']) ?></small>
    </h2>

    <div id="feedbackMessage" class="alert d-none text-center"></div>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Bestellnr.</th>
                <th>Datum</th>
                <th>Preis</th>
                <th>Status</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody id="orderList">
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr data-id="<?= $row['order_id'] ?>">
                    <td>#<?= $row['order_id'] ?></td>
                    <td><?= $row['order_date'] ?></td>
                    <td><?= number_format($row['total_price'], 2, ',', '.') ?> €</td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <a href="order-item-delete.php?order_id=<?= $row['order_id'] ?>" class="btn btn-sm btn-outline-info me-1">
                            Details
                        </a>
                        <button class="btn btn-sm btn-outline-danger delete-order-btn">
                            Löschen
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="../js/order-delete.js"></script>
<?php include('footer.php'); ?>
</body>
</html>
