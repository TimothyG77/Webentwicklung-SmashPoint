<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

require_once '../../Backend/config/dbaccess.php';
$result = $conn->query("SELECT product_name, price, product_picture FROM produkte ORDER BY ID DESC LIMIT 3");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../res/css/style.css"> 

</head>
<body>
    <?php include 'header.php' ?>
    <?php
    if (isset($_GET['login']) && $_GET['login'] === 'success' && isset($_SESSION['user'])) {
    $username = htmlspecialchars($_SESSION['user']);
    echo '<div class="alert alert-success text-center mt-4" role="alert">
    Login war erfolgreich! Willkommen zurück, <strong>' . $username . '!</strong>
    </div>';
    }
    ?>

    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<img src='../../Backend/{$row['product_picture']}' class='card-img-top'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>{$row['product_name']}</h5>";
        echo "<p class='card-text'><strong>{$row['price']} €</strong></p>";
        echo "</div></div>";
    }
    ?>



    <?php include 'footer.php' ?>
    
</body>
</html>