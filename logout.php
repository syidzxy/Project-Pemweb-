<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Logout Berhasil</h1>
        <a href="login.php">Login</a>
    </div>
</body>
</html>
