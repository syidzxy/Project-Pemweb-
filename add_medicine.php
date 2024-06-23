<?php
include 'includes/functions.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    if (tambah_obat($name, $description, $quantity)) {
        echo "Obat berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($DB);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input, form textarea, form button {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #4cae4c;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Obat</h1>
        <form method="post" action="add_medicine.php">
            <input type="text" name="name" placeholder="Nama Obat" required>
            <input type="number" name="quantity" placeholder="Jumlah" required>
            <textarea name="description" placeholder="Deskripsi Obat" rows="5" required></textarea>
            <button type="submit">Tambah</button>
        </form>
        <a href="medicines.php">Kembali ke Manage Medicines</a>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
