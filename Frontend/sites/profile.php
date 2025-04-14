<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Backend/config/dbaccess.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT salutation, firstname, lastname, address, postal_code, city, email, username, role FROM User WHERE ID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($salutation, $firstname, $lastname, $address, $postal_code, $city, $email, $username, $role);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Mein Profil - SmashPoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Mein Profil</h2>

    <form id="profileForm">
        <div class="mb-3">
            <label class="form-label">Anrede</label>
            <select name="salutation" class="form-select" required>
                <option value="Herr" <?= $salutation === 'Herr' ? 'selected' : '' ?>>Herr</option>
                <option value="Frau" <?= $salutation === 'Frau' ? 'selected' : '' ?>>Frau</option>
                <option value="Divers" <?= $salutation === 'Divers' ? 'selected' : '' ?>>Divers</option>
            </select>
        </div>

        <div class="mb-3"><label class="form-label">Vorname</label><input type="text" name="firstname" value="<?= htmlspecialchars($firstname) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Nachname</label><input type="text" name="lastname" value="<?= htmlspecialchars($lastname) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Adresse</label><input type="text" name="address" value="<?= htmlspecialchars($address) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">PLZ</label><input type="text" name="postal_code" value="<?= htmlspecialchars($postal_code) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Ort</label><input type="text" name="city" value="<?= htmlspecialchars($city) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">E-Mail</label><input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Benutzername</label><input type="text" name="username" value="<?= htmlspecialchars($username) ?>" class="form-control" required></div>

        <button type="submit" class="btn btn-primary w-100">Änderungen speichern</button>
    </form>

    <!-- AJAX Feedback -->
    <div id="update-success" class="alert alert-success d-none mt-3 text-center"></div>
    <div id="update-error" class="alert alert-danger d-none mt-3 text-center"></div>

    <div class="text-center mt-4">
        <a href="logout.php" class="btn btn-outline-danger">🚪 Ausloggen</a>
    </div>

    <?php if ($role === 'admin'): ?>
        <div class="text-center mt-3">
            <a href="user-overview.php" class="btn btn-outline-primary">👥 Benutzerübersicht</a>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>
<script src="../js/profile.js"></script>
</body>
</html>
