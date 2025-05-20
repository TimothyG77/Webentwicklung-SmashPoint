<?php
session_start();
require_once '../../Backend/config/dbaccess.php';

// Zugriffsschutz
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Adminrolle prüfen
$userID = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT role FROM User WHERE ID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') {
    echo "<div class='container mt-5 alert alert-danger'>Nur Administratoren haben Zugriff auf diese Seite.</div>";
    exit;
}

// Alle User abrufen
$result = $conn->query("SELECT ID, firstname, lastname, email, username, role, status FROM User");
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Benutzerübersicht - SmashPoint</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Benutzerübersicht</h2>

    <!--AJAX Feedback-Meldung -->
    <div id="feedbackMessage" class="alert d-none text-center"></div>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Benutzername</th>
                <th>Rolle</th>
                <th>Status</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
        <!--Wenn ein User den Status inaktiv hat in der DB, dann wird die Tabelle leicht rot markiert
        und stopPropagation() ist nützlich, damit ich auch nur den Button ?Aktivieren?
        oder deaktivieren klicke und nicht auch die ganze Tabelle-->
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="user-row <?= $row['status'] === 'inaktiv' ? 'table-danger' : '' ?>" data-id="<?= $row['ID'] ?>" style="cursor: pointer;">
                <td><?= $row['ID'] ?></td>
                <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['role'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['ID'] != $userID): ?>
                        <button 
                            class="btn btn-sm toggle-status-btn <?= $row['status'] === 'aktiv' ? 'btn-danger' : 'btn-success' ?>"
                            data-id="<?= $row['ID'] ?>" 
                            data-status="<?= $row['status'] ?>"
                            onclick="event.stopPropagation();">
                            <?= $row['status'] === 'aktiv' ? 'Deaktivieren' : 'Aktivieren' ?>
                        </button>
                    <?php else: ?>
                        <span class="text-muted">Du</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>

    </table>
</div>

<script src="../js/user-overview.js"></script>
<?php include('footer.php'); ?>
</body>
</html>
