<?php
// Masukkan koneksi ke database atau fungsi-fungsi lainnya
include 'includes/functions.php';

// Pastikan session tidak aktif sebelum memulai session baru
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi pesan error
$errorMessage = '';

// Cek apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Proses login
    if (login($username, $password)) {
        // Redirect ke halaman dashboard jika login berhasil
        header("Location: dashboard.php");
        exit();
    } else {
        $errorMessage = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if ($errorMessage !== '') : ?>
            <div class="message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
