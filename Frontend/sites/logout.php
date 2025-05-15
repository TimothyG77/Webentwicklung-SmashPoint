<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <script>
        localStorage.removeItem("cart"); //leere localStorage
        window.location.href = "index.php?logout=1";
    </script>
</head>
<body></body>
</html>
<?php exit; ?>
