<?php
require_once '../config/dbaccess.php';

// Live Username überprüfen mit AJAX
if (isset($_POST['benutzername'])) {
    $username = $_POST['benutzername'];
    $stmt = $conn->prepare("SELECT ID FROM User WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    echo $stmt->num_rows > 0 ? "taken" : "free";
    $stmt->close();
    $conn->close();
}
?>
