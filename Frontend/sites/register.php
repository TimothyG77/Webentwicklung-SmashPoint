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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>

<!-- Registrierungsformular -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Registrierung</h2>
            <form action="register.php" method="POST" class="needs-validation" novalidate>
                
                <!-- Anrede -->
                <div class="mb-3">
                    <label for="anrede" class="form-label">Anrede</label>
                    <select class="form-select" id="anrede" name="anrede" required>
                        <option value="">Bitte wählen...</option>
                        <option value="Herr">Herr</option>
                        <option value="Frau">Frau</option>
                        <option value="Divers">Divers</option>
                    </select>
                    <div class="invalid-feedback">Bitte eine Anrede auswählen.</div>
                </div>

                <!-- Vorname -->
                <div class="mb-3">
                    <label for="vorname" class="form-label">Vorname</label>
                    <input type="text" class="form-control" id="vorname" name="vorname" required>
                    <div class="invalid-feedback">Bitte geben Sie Ihren Vornamen ein.</div>
                </div>

                <!-- Nachname -->
                <div class="mb-3">
                    <label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" id="nachname" name="nachname" required>
                    <div class="invalid-feedback">Bitte geben Sie Ihren Nachnamen ein.</div>
                </div>

                <!-- Adresse -->
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                    <div class="invalid-feedback">Bitte geben Sie Ihre Adresse ein.</div>
                </div>

                <!-- PLZ -->
                <div class="mb-3">
                    <label for="plz" class="form-label">PLZ</label>
                    <input type="text" class="form-control" id="plz" name="plz" pattern="\d{4}" required>
                    <div class="invalid-feedback">Bitte geben Sie eine gültige PLZ (4-stellig) ein.</div>
                </div>

                <!-- Ort -->
                <div class="mb-3">
                    <label for="ort" class="form-label">Ort</label>
                    <input type="text" class="form-control" id="ort" name="ort" required>
                    <div class="invalid-feedback">Bitte geben Sie Ihren Wohnort ein.</div>
                </div>

                <!-- E-Mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-Mail-Adresse</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Bitte geben Sie eine gültige E-Mail-Adresse ein.</div>
                </div>

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
                    <div class="invalid-feedback">Bitte geben Sie ein Passwort ein.</div>
                </div>

                <!-- Zahlungsinformationen 
                <div class="mb-3">
                    <label for="zahlung" class="form-label">Zahlungsinformationen</label>
                    <input type="text" class="form-control" id="zahlung" name="zahlung" required>
                    <div class="invalid-feedback">Bitte geben Sie Ihre Zahlungsinformationen ein.</div>
                </div>
                -->

                <!-- Submit-Button -->
                <button type="submit" class="btn btn-primary w-100">Registrieren</button>
            </form>
        </div>
    </div>
</div>
<script src="Frontend/js/register.js"></script>
</body>
</html>
