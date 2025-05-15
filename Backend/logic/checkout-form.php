<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

if (isset($_GET['validateVoucher'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    $code = trim($input['code'] ?? '');

    $stmt = $conn->prepare("SELECT value, expires_at, used FROM vouchers WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->bind_result($value, $expires, $used);

    if ($stmt->fetch()) {
        $now = date("Y-m-d H:i:s");
        echo json_encode([
            'valid' => !$used && $expires > $now,
            'value' => !$used && $expires > $now ? floatval($value) : null
        ]);
    } else {
        echo json_encode(['valid' => false]);
    }

    $stmt->close();
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit;
}
$userID = $_SESSION['user_id'];

if (isset($_GET['products'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    $cart = array_map('intval', $input['cart'] ?? []);

    if (empty($cart)) {
        echo json_encode([]);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $types = str_repeat('i', count($cart));

    $stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE ID IN ($placeholders)");
    $stmt->bind_param($types, ...$cart);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
    exit;
}

if (isset($_GET['placeOrder'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    $cart = $input['cart'] ?? [];
    $voucherCode = trim($input['voucher'] ?? "");
    $voucherValue = null;

    if (empty($cart)) {
        echo json_encode(['success' => false, 'message' => 'Warenkorb ist leer.']);
        exit;
    }

    $productIDs = array_map(fn($item) => intval($item['id']), $cart);
    $placeholders = implode(',', array_fill(0, count($productIDs), '?'));
    $types = str_repeat('i', count($productIDs));

    $stmt = $conn->prepare("SELECT ID, price FROM produkte WHERE ID IN ($placeholders)");
    $stmt->bind_param($types, ...$productIDs);
    $stmt->execute();
    $result = $stmt->get_result();

    $productPrices = [];
    while ($row = $result->fetch_assoc()) {
        $productPrices[$row['ID']] = (float) $row['price'];
    }

    $total = 0;
    foreach ($cart as $item) {
        $pid = $item['id'];
        $qty = $item['qty'] ?? 1;
        $total += ($productPrices[$pid] ?? 0) * $qty;
    }

    if ($voucherCode !== "") {
        $voucherStmt = $conn->prepare("SELECT id, value, expires_at, used FROM vouchers WHERE code = ?");
        $voucherStmt->bind_param("s", $voucherCode);
        $voucherStmt->execute();
        $voucher = $voucherStmt->get_result()->fetch_assoc();
        $voucherStmt->close();

        if (!$voucher || $voucher['used'] || $voucher['expires_at'] < date("Y-m-d H:i:s")) {
            echo json_encode(['success' => false, 'message' => 'Ungültiger oder abgelaufener Gutschein.']);
            exit;
        }

        $voucherValue = floatval($voucher['value']);
        $total -= $total * ($voucherValue / 100);

        $markUsed = $conn->prepare("UPDATE vouchers SET used = 1 WHERE id = ?");
        $markUsed->bind_param("i", $voucher['id']);
        $markUsed->execute();
        $markUsed->close();
    }

    $stmt = $conn->prepare("SELECT CONCAT(address, ', ', postal_code, ' ', city) FROM user WHERE ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($shipping);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, total_price, status, shipping_adress, invoice_number, voucher_percent) VALUES (?, NOW(), ?, 'bestellt', ?, '', ?)");
    $stmt->bind_param("idsd", $userID, $total, $shipping, $voucherValue);
    $stmt->execute();
    $orderID = $stmt->insert_id;
    $stmt->close();

    $invoiceNumber = $orderID . '-' . date("Ymd");
    $stmt = $conn->prepare("UPDATE orders SET invoice_number = ? WHERE order_id = ?");
    $stmt->bind_param("si", $invoiceNumber, $orderID);
    $stmt->execute();
    $stmt->close();

    foreach ($cart as $item) {
        $pid = $item['id'];
        $qty = $item['qty'] ?? 1;
        $price = $productPrices[$pid] ?? 0;

        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_each) VALUES (?, ?, ?, ?)");
        $stmtItem->bind_param("iiid", $orderID, $pid, $qty, $price);
        $stmtItem->execute();
        $stmtItem->close();
    }

    $deleteCartStmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $deleteCartStmt->bind_param("i", $userID);
    $deleteCartStmt->execute();
    $deleteCartStmt->close();

    $conn->close();
    echo json_encode(['success' => true]);
}
