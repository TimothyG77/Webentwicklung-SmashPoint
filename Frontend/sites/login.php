<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - SmashPoint</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Registrierung</h2>
            <form action="register.php" method="POST" class="needs-validation" novalidate>

                <!-- Benutzername -->
                <div class="mb-3">
                    <label for="benutzername" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="benutzername" name="benutzername" required>
                    <div class="invalid-feedback">Bitte geben Sie einen Benutzernamen ein.</div>
                </div>

                <!-- Passwort -->
                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁</button>
                    </div>
                    <div class="invalid-feedback">Bitte geben Sie ein valides Passwort ein.</div>
                </div>

                <!-- Submit-Button -->
                <button type="submit" class="btn btn-primary w-100">Anmelden</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>