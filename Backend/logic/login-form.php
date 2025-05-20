<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['remember'])) {
        ini_set('session.cookie_lifetime', 86400 * 30);
        session_set_cookie_params(86400 * 30);
    } else {
        ini_set('session.cookie_lifetime', 0);
        session_set_cookie_params(0);
    }

    session_start();
    require_once '../config/dbaccess.php';

    $identifier = $_POST['username']; // Kann Benutzername ODER E-Mail sein
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT ID, username, password, role, status 
        FROM User 
        WHERE username = ? OR email = ?
        LIMIT 1
    ");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userID, $username, $hashedPassword, $role, $status);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {

            if ($status !== 'aktiv') {
                $_SESSION['disabled_user'] = $identifier;
                $_SESSION['disabled_pass'] = $password;
                header("Location: ../../Frontend/sites/login.php?login=disabled");
                exit;
            }

            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $userID;
            $_SESSION['role'] = $role;
            $_SESSION['just_logged_in'] = true;

            // Mit setcookie falls die Bedinungen passen, den Benutzernamen und Passwort 30 Tage lang merken
            if (isset($_POST['remember'])) {
                setcookie('remembered_user', $identifier, time() + (86400 * 30), "/");
                setcookie('remembered_pass', base64_encode($password), time() + (86400 * 30), "/");
                setcookie('remember_login', 'true', time() + (86400 * 30), "/");
            } else {
                setcookie('remembered_user', '', time() - 3600, "/");
                setcookie('remembered_pass', '', time() - 3600, "/");
                setcookie('remember_login', '', time() - 3600, "/");
            }

            header("Location: ../../Frontend/sites/index.php?login=success");
            exit;
        }
    }

    header("Location: ../../Frontend/sites/login.php?login=failed");
    exit;
}
?>
