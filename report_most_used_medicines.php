<?php
include 'includes/functions.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$DB = mysqli_connect("localhost", "id22299619_poskestren", "Poskestren123@", "id22299619_posko_kesehatan"); // Sesuaikan dengan pengaturan Anda

$result = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query untuk menghitung total quantity obat yang diberikan kepada pasien
    $query = "SELECT m.name AS medicine_name, 
                     COUNT(DISTINCT p.id) AS total_patients, 
                     SUM(p.quantity) AS total_quantity
              FROM patients p
              JOIN medicines m ON p.medicine_id = m.id
              WHERE p.date BETWEEN '$start_date' AND '$end_date'
              GROUP BY p.medicine_id
              ORDER BY total_quantity DESC";

    $result = mysqli_query($DB, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Obat yang Paling Banyak Dikeluarkan</title>
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="date"] {
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

        p {
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Report Obat yang Paling Banyak Dikeluarkan</h1>
        <form method="post" action="report_most_used_medicines.php">
            <label for="start_date">Tanggal Awal:</label>
            <input type="date" id="start_date" name="start_date" required>
            <label for="end_date">Tanggal Akhir:</label>
            <input type="date" id="end_date" name="end_date" required>
            <button type="submit">Generate Report</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $result && mysqli_num_rows($result) > 0) : ?>
            <h2>Hasil Report</h2>
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
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
            <p>Tidak ada data yang ditemukan untuk rentang waktu tersebut.</p>
        <?php endif; ?>

        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
