<?php
session_start();
header('Content-Type: application/json');
require_once '../config/dbaccess.php';

// Wenn die URL den GET-Parameter "validateVoucher" enthält, wird der Code darunter ausgeführt
if (isset($_GET['validateVoucher'])) { // Vom AJAX Call in checkout.js -> Zeile 23
    $input = json_decode(file_get_contents("php://input"), true);
    $code = trim($input['code'] ?? ''); // Liest den Gutscheincode und wenn keiner vorhanden ist, dann soll ein leerer String verwendet werden

    // Gutschein aus der Datenbank holen
    $stmt = $conn->prepare("SELECT value, expires_at, used FROM vouchers WHERE code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $stmt->bind_result($value, $expires, $used);

    // Prüft ob der Gutschein gefunden wurde, holt das aktuelle Datum mit Zeit ($now)
    // Gutschein valid wenn used == 0 und expires_at in der Zukunft liegt
    if ($stmt->fetch()) {
        $now = date("Y-m-d H:i:s");
        echo json_encode([
            // Die PHP-Variablenbenennungen müssen nicht die gleichen sein wie von der Datenbank
            // Die Variablen werden nach der Reihenfolge der erstellten Spalten der DB gelesen
            'valid' => !$used && $expires > $now,
            'value' => !$used && $expires > $now ? floatval($value) : null
        ]);
    } else {
        echo json_encode(['valid' => false]);
    }

    $stmt->close();
    exit;
}

// Sicherheitsmaßnahme
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt.']);
    exit;
}

// userID wird aus dem SESSION Array gelesen
$userID = $_SESSION['user_id'];

if (isset($_GET['products'])) {
    $input = json_decode(file_get_contents("php://input"), true);
    
    // Sicherheitsmaßnahme -> array_map stellt sicher, dass alle Werte ganze Zahlen enthalten
    $cart = array_map('intval', $input['cart'] ?? []);

    if (empty($cart)) {
        echo json_encode([]);
        exit;
    }

    // Baut die SQL-ABfrage (?, ?, ?)
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    // Der Typ der Daten (in dem Fall Integers (i))
    $types = str_repeat('i', count($cart));

    // Holt zu jeder PRodukt-ID den Namen, die Beschreibung sowie andere wichtige Daten
    $stmt = $conn->prepare("SELECT ID AS id, product_name, product_description, price, product_picture FROM produkte WHERE ID IN ($placeholders)");
    $stmt->bind_param($types, ...$cart);
    $stmt->execute();
    $result = $stmt->get_result();

    // Die gefilterten Ergebnisse werden ins Array products gespeichert und zum Frontend geschickt
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
    exit;
}

// Überprüft ob der Wert placeOrder gesetzt ist im URL und liest ihn
if (isset($_GET['placeOrder'])) {
    // Liest die JSON Daten
    $input = json_decode(file_get_contents("php://input"), true);
    $cart = $input['cart'] ?? []; // $cart -> Liste mit {id, qty}
    $voucherCode = trim($input['voucher'] ?? ""); // Gutschein, falls vorhanden
    $voucherValue = null; // Wird später mit Prozentwert gefüllt

    // Sicherheitsmaßnahme
    if (empty($cart)) {
        echo json_encode(['success' => false, 'message' => 'Warenkorb ist leer.']);
        exit;
    }

    // Wir holen alle Produkte aus der Datenbank, passend zu den Produkt-IDs im Warenkorb
    $productIDs = array_map(fn($item) => intval($item['id']), $cart);
    $placeholders = implode(',', array_fill(0, count($productIDs), '?'));
    $types = str_repeat('i', count($productIDs));

    // Die Preise der Produkte, die zu den IDs passen werden aus der DB von der Tabelle produkte geholt
    $stmt = $conn->prepare("SELECT ID, price FROM produkte WHERE ID IN ($placeholders)");
    $stmt->bind_param($types, ...$productIDs);
    $stmt->execute();
    $result = $stmt->get_result(); 

    // Die Preise werden mit der ID in das Array gespeichert für die Berechnung des Gesamtpreises
    $productPrices = [];
    while ($row = $result->fetch_assoc()) {
        $productPrices[$row['ID']] = (float) $row['price'];
    }

    // Gesamtpreis berechnen
    $total = 0;
    foreach ($cart as $item) {
        $pid = $item['id'];
        $qty = $item['qty'] ?? 1;
        $total += ($productPrices[$pid] ?? 0) * $qty;
    }

    // Gutschein überprüfen und anwenden
    if ($voucherCode !== "") { 
        // Holt den Gutschein aus der DB, wenn der Gutscheincode nicht leer ist
        $voucherStmt = $conn->prepare("SELECT id, value, expires_at, used FROM vouchers WHERE code = ?");
        $voucherStmt->bind_param("s", $voucherCode);
        $voucherStmt->execute();
        $voucher = $voucherStmt->get_result()->fetch_assoc();
        $voucherStmt->close();

        // Prüft ob der Gutschein existiert sowie noch gültig ist
        if (!$voucher || $voucher['used'] || $voucher['expires_at'] < date("Y-m-d H:i:s")) {
            echo json_encode(['success' => false, 'message' => 'Ungültiger oder abgelaufener Gutschein.']);
            exit;
        }

        // Berechnet den Rabatt und zieht es von der Variable $total ab
        $voucherValue = floatval($voucher['value']);
        $total -= $total * ($voucherValue / 100);

        // Markiert den Gutschein als verwendet -> used = 1 (true)
        $markUsed = $conn->prepare("UPDATE vouchers SET used = 1 WHERE id = ?");
        $markUsed->bind_param("i", $voucher['id']);
        $markUsed->execute();
        $markUsed->close();
    }

    // Varsandadresse wir als String zusammengebaut
    $stmt = $conn->prepare("SELECT CONCAT(address, ', ', postal_code, ' ', city) FROM user WHERE ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($shipping);
    $stmt->fetch();
    $stmt->close();

    // Die Bestellung wird in der Tabelle orders gespeichert
    $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, total_price, status, shipping_adress, invoice_number, voucher_percent) VALUES (?, NOW(), ?, 'bestellt', ?, '', ?)");
    $stmt->bind_param("idsd", $userID, $total, $shipping, $voucherValue);
    $stmt->execute();
    $orderID = $stmt->insert_id;
    $stmt->close();

    // Die Rechnungsnummer wird generiert und in der Tabelle orders gespeichert 
    $invoiceNumber = $orderID . '-' . date("Ymd"); // Generierung der Rechnungsnummer
    $stmt = $conn->prepare("UPDATE orders SET invoice_number = ? WHERE order_id = ?"); // Nachträgliche Speicherung, da orderID erst nach dem INSERT Befehl bekannt ist
    $stmt->bind_param("si", $invoiceNumber, $orderID);
    $stmt->execute();
    $stmt->close();

    // Produkte in der order_items Tabelle speichern
    foreach ($cart as $item) {
        $pid = $item['id'];
        $qty = $item['qty'] ?? 1;
        $price = $productPrices[$pid] ?? 0;

        $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_each) VALUES (?, ?, ?, ?)");
        $stmtItem->bind_param("iiid", $orderID, $pid, $qty, $price);
        $stmtItem->execute();
        $stmtItem->close();
    }

    // Der Warenkorb des Users wird gelöscht und auf 0 gesetzt
    $deleteCartStmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $deleteCartStmt->bind_param("i", $userID);
    $deleteCartStmt->execute();
    $deleteCartStmt->close();

    $conn->close();
    echo json_encode(['success' => true]);
}
