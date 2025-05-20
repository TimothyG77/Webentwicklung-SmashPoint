<?php
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung - SmashPoint</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php include('header.php'); ?>

<!-- Registrierungsformular -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center">Registrierung</h2>
            <form id="registerForm">
                
                <!-- Anrede und alle anderen Dateneingaben -->
                <div class="mb-3">
                    <label for="anrede" class="form-label">Anrede</label>
                    <select class="form-select" id="anrede" name="anrede" required>
                        <option value="">Bitte wählen...</option>
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                        <option value="Divers">Divers</option>
                    </select>
                </div>

                <div class="mb-3"><label for="vorname" class="form-label">Vorname</label>
                    <input type="text" class="form-control" id="vorname" name="vorname" required></div>

                <div class="mb-3"><label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" id="nachname" name="nachname" required></div>

                <div class="mb-3"><label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" required></div>

                <div class="mb-3"><label for="plz" class="form-label">PLZ</label>
                    <input type="text" class="form-control" id="plz" name="plz" required>
                    <div class="invalid-feedback">Bitte eine gültige PLZ (4 oder 5-stellig) eingeben.</div>
                </div>

                <div class="mb-3"><label for="ort" class="form-label">Ort</label>
                    <input type="text" class="form-control" id="ort" name="ort" required></div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail-Adresse</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div id="email-feedback" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="benutzername" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="benutzername" name="benutzername" required>
                    <div id="username-check" class="form-text text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Passwort</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁</button>
                    </div>
                    <div id="password-feedback" class="invalid-feedback">
                        Passwort muss mindestens 7 Zeichen lang sein und eine Zahl sowie ein Sonderzeichen enthalten.
                    </div>
                </div>


                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Passwort bestätigen</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">👁</button>
                    </div>
                </div>

                <!-- Feedback-Bereiche -->
                <div id="register-success" class="alert alert-success d-none mt-3"></div>
                <div id="register-error" class="alert alert-danger d-none mt-3"></div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">Registrieren</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script src="../js/register.js"></script>
</body>
</html>
