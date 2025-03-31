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
<?php include('header.php'); ?>

<!-- Registrierungsformular -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
             <!-- Display success or error messages -->
            <?php 
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo '<div class="alert alert-success" role="alert">';
                echo 'Registration was successful!';
                echo '</div>';
            }

            if (isset($_GET['error'])) {
                $error_message = '';
                switch ($_GET['error']) {
                    case 'password_error':
                        $error_message = 'Password is incorrect. Try again.';
                        break;
                    case 'email_error':
                        $error_message = 'Please enter a valid email address.';
                        break;
                    case 'password_symbols_error':
                        $error_message = 'The password must be at least 8 characters long, contain at least one number, and one special character.';
                        break;
                    case 'user_exists_error':
                        $error_message = 'The username is already taken. Please choose a different one.';
                        break;
            }
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
    }
    ?>

            <h2 class="text-center">Registrierung</h2>
            <form action="../../Backend/logic/register-form.php" method="POST">
                
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
                    <div id="email-feedback" class="form-text text-danger"></div>
                    <div class="invalid-feedback">Bitte geben Sie eine gültige E-Mail-Adresse ein.</div>
                </div>

                <!-- Benutzername -->
                <div class="mb-3">
                    <label for="benutzername" class="form-label">Benutzername</label>
                    <input type="text" class="form-control" id="benutzername" name="benutzername" required>
                    <div id="username-check" class="form-text text-danger"></div>
                    <div class="invalid-feedback">Bitte geben Sie einen anderen Benutzernamen ein.</div>
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

                <!-- Passwort bestätigen -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Passwort bestätigen</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">👁</button>
                    </div>
                    <div class="invalid-feedback">Bitte bestätigen Sie Ihr Passwort.</div>
                </div>

                <!-- Submit-Button -->
                <button type="submit" class="btn btn-primary w-100">Registrieren</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<script src="../js/register.js"></script>
</body>
</html>
