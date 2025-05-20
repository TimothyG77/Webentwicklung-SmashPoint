<?php
require_once '../config/dbaccess.php';

// Live Email überpüfen mit AJAX
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT ID FROM User WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows > 0 ? "taken" : "free"; // Auch hier die Werte entweder "taken" oder "free"
    $stmt->close();
    $conn->close();
}
?>
