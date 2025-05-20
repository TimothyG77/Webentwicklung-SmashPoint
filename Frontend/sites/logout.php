<?php
session_start(); // Alle SESSION Daten werden gelöscht
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <script>
        localStorage.removeItem("cart"); //leere localStorage
        window.location.href = "index.php?logout=1"; // Nach Logout zur Startseite geführt
    </script>
</head>
<body></body>
</html>
<?php exit; ?>
