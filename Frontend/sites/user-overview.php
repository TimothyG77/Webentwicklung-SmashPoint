<?php
session_start();
require_once '../../Backend/config/dbaccess.php';

// Zugriffsschutz
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userID = $_SESSION['user_id'];

// Adminrolle prüfen
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

// Status ändern (wenn GET-Parameter gesetzt)
if (isset($_GET['toggle']) && isset($_GET['id'])) {
    $toggleID = intval($_GET['id']);
    $newStatus = $_GET['toggle'] === 'deactivate' ? 'inaktiv' : 'aktiv';

    $update = $conn->prepare("UPDATE User SET status = ? WHERE ID = ?");
    $update->bind_param("si", $newStatus, $toggleID);
    $update->execute();
    $update->close();

    header("Location: user-overview.php");
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
</head>
<body>
<?php include('header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Benutzerübersicht</h2>

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
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="<?= $row['status'] === 'inaktiv' ? 'table-danger' : '' ?>">
                <td><?= $row['ID'] ?></td>
                <td><?= $row['firstname'] . " " . $row['lastname'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['role'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['ID'] != $userID): ?>
                        <?php if ($row['status'] === 'aktiv'): ?>
                            <a href="?toggle=deactivate&id=<?= $row['ID'] ?>" class="btn btn-sm btn-danger">🛑 Deaktivieren</a>
                        <?php else: ?>
                            <a href="?toggle=activate&id=<?= $row['ID'] ?>" class="btn btn-sm btn-success">✅ Aktivieren</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">Du</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>
</body>
</html>
