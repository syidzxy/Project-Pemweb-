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

// Pengeluaran obat bulan ini
$currentMonth = date('m');
$currentYear = date('Y');
$start_date = date('Y-m-01');
$end_date = date('Y-m-t');
$query = "SELECT m.name AS medicine_name, 
                 COUNT(DISTINCT p.id) AS total_patients, 
                 SUM(p.quantity) AS total_quantity
          FROM patients p
          JOIN medicines m ON p.medicine_id = m.id
          WHERE p.date BETWEEN '$start_date' AND '$end_date'
          GROUP BY p.medicine_id
          ORDER BY total_quantity DESC";
$result = mysqli_query($DB, $query);

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
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
            overflow-x: auto;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary table th, .summary table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .summary table th {
            background-color: #f2f2f2;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: green;
        }

        .menu-container {
            text-align: center;
            margin-top: 20px;
        }

        .menu {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .menu li {
            margin: 0 10px;
        }

        .menu li a {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .menu li a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        
        <div class="summary">
            <h2>Pengeluaran Obat Bulan Ini</h2>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah Pasien</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['medicine_name']; ?></td>
                                <td><?php echo $row['total_patients']; ?></td>
                                <td><?php echo $row['total_quantity']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Tidak ada data untuk bulan ini.</p>
            <?php endif; ?>
        </div>

        <?php if ($message !== "") : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="menu-container">
            <ul class="menu">
                <li><a href="medicines.php">Kelola Obat</a></li>
                <li><a href="report_most_used_medicines.php">Report Obat Terbanyak</a></li>
                <li><a href="patient_presence.php">Form Pemberian Obat</a></li>
                <li><a href="patients_list.php">Daftar Pasien</a></li>
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
                    <li><a href="register.php">Register Petugas</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
