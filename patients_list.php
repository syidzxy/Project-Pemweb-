<?php
// Pastikan session belum aktif sebelum memulai session baru
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Masukkan koneksi ke database atau fungsi-fungsi lainnya
include 'includes/functions.php';

// Redirect ke halaman login jika tidak ada session aktif
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$DB = mysqli_connect("localhost", "id22299619_poskestren", "Poskestren123@", "id22299619_posko_kesehatan");

// Periksa apakah koneksi berhasil
if (!$DB) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query untuk mengambil data pasien
$query = "SELECT p.id, p.name AS patient_name, m.name AS medicine_name, p.quantity, p.date
          FROM patients p
          JOIN medicines m ON p.medicine_id = m.id";
$result = mysqli_query($DB, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query failed: " . mysqli_error($DB));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pasien</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .dashboard-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Pasien</h1>

        <table>
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>Nama Obat</th>
                    <th>Jumlah Obat</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['patient_name']; ?></td>
                        <td><?php echo $row['medicine_name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="dashboard-button">Kembali ke Dashboard</a>
    </div>
</body>
</html>
