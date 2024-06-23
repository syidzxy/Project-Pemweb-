<?php
// Pastikan session belum aktif sebelum memulai session baru
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includes/functions.php';

// Redirect ke halaman login jika tidak ada session aktif
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        $message = "Registrasi berhasil!";
    } else {
        $message = "Registrasi gagal!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Petugas</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            width: 30%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register Petugas</h1>
        
        <?php if ($message !== "") : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password2" placeholder="Konfirmasi Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        
        <div style="text-align: center; margin-top: 10px;">
            <a href="dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
