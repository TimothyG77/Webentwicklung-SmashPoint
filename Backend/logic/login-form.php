<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../config/dbaccess.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT ID, password, role FROM User WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userID, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $userID;
            $_SESSION['role'] = $role;

            //Login merken für 30 Tage
            if (isset($_POST['remember'])) {
                setcookie('remembered_user', $username, time() + (86400 * 30), "/");
            } else {
                // Cookie löschen, falls vorher gesetzt
                setcookie('remembered_user', '', time() - 3600, "/");
            }
        
            header("Location: ../../Frontend/sites/index.php?login=success");
            exit;
        }
    }

    header("Location: ../../Frontend/sites/login.php?login=failed");
    exit;
}
?>
