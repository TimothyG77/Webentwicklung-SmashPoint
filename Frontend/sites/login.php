<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['login']) && $_GET['login'] == "disabled") {
    echo '<div class="alert alert-warning mt-3 text-center">Ihr Benutzerkonto wurde vom Admin deaktiviert.</div>';
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login - SmashPoint</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Login</h2>

            <form action="../../Backend/logic/login-form.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Benutzername oder E-Mail Adresse</label>
                    <!--SESSION disabled user wird gesetzt wenn der Benutzer deaktiviert isset
                    und $_COOKIE wird gesetzt, wenn der Benutzer "Login merken" ausgewählt hat-->
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?= htmlspecialchars($_SESSION['disabled_user'] ?? ($_COOKIE['remembered_user'] ?? '')) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                               value="<?= htmlspecialchars($_SESSION['disabled_pass'] ?? (isset($_COOKIE['remembered_pass']) ? base64_decode($_COOKIE['remembered_pass']) : '')) ?>"
                               required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁</button>
                    </div>
                </div>

                <!--Der Wert remembered_user kommt vom Backend - login-form.php-->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        <?= isset($_COOKIE['remembered_user']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="remember">Login merken</label>
                </div>

                <button type="submit" class="btn btn-success w-100">Einloggen</button>
            </form>

            <?php if (isset($_GET['login']) && $_GET['login'] == "failed"): ?>
                <div class="alert alert-danger mt-3 text-center">Login fehlgeschlagen. Bitte überprüfen Sie Ihre Daten.</div>
            <?php endif; ?>

            <div class="text-center mt-4">
                <p>Noch kein Kunde? <a href="register.php" class="btn btn-link">Jetzt registrieren</a></p>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script src="../js/login.js"></script>
</body>
</html>
