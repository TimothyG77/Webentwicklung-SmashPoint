<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../../Backend/config/dbaccess.php';

$stmt = $conn->prepare("SELECT ID, product_name, product_description, price, product_picture FROM produkte");
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte löschen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="container mt-5">
    <h2 class="mb-4">Produkte löschen</h2>

    <div id="productList" class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4" data-id="<?= $product['ID'] ?>">
                <div class="card">
                    <img src="../../Backend/<?= htmlspecialchars($product['product_picture']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['product_description']) ?></p>
                        <p class="card-text"><strong><?= number_format($product['price'], 2) ?> €</strong></p>
                        <button class="btn btn-danger delete-product">🗑️ Löschen</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="../js/product-delete.js"></script>
</body>
</html>
