<?php
session_start();

// Periksa apakah pengguna sudah login
$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;

// Koneksi ke database
$DB = mysqli_connect("localhost", "id22299619_poskestren", "Poskestren123@", "id22299619_posko_kesehatan");

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query untuk mengambil data obat yang tidak dihapus
$sql = "SELECT * FROM medicines WHERE deleted = 0";
$result = mysqli_query($DB, $sql);

// Simpan hasil query ke variabel $medicines
$medicines = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $medicines[] = $row;
    }
}

// Tutup koneksi database
mysqli_close($DB);

// Fungsi untuk melakukan soft delete obat
function deleteMedicine($id) {
    global $DB;
    $id = mysqli_real_escape_string($DB, $id);
    $sql = "UPDATE medicines SET deleted = 1 WHERE id = '$id'";
    return mysqli_query($DB, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicines</title>
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
        }

        .container {
            width: 90%;
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

        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 80%;
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
        }

        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        ul li {
            display: inline;
            margin-right: 10px;
        }

        ul li a {
            text-decoration: none;
            color: #007BFF;
        }

        ul li a:hover {
            text-decoration: underline;
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

        /* Responsiveness */
        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
            }

            .search-form input[type="text"] {
                width: 100%;
                max-width: none;
            }
        }
    </style>
    <script>
        function searchMedicines() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let table = document.getElementById('medicinesTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[0];
                let tdDescription = tr[i].getElementsByTagName('td')[2];
                if (tdName || tdDescription) {
                    let textValueName = tdName.textContent || tdName.innerText;
                    let textValueDescription = tdDescription.textContent || tdDescription.innerText;
                    if (textValueName.toLowerCase().indexOf(input) > -1 || textValueDescription.toLowerCase().indexOf(input) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Manage Medicines</h1>

        <!-- Form pencarian -->
        <div class="search-form">
            <input type="text" id="searchInput" onkeyup="searchMedicines()" placeholder="Cari obat atau deskripsi...">
        </div>

        <!-- Tabel untuk menampilkan obat -->
        <table id="medicinesTable">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <?php if ($loggedIn) : ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($medicines)) : ?>
                    <?php foreach ($medicines as $medicine) : ?>
                        <tr>
                            <td><?php echo $medicine['name']; ?></td>
                            <td><?php echo $medicine['quantity']; ?></td>
                            <td><?php echo $medicine['description']; ?></td>
                            <?php if ($loggedIn) : ?>
                                <td class="actions">
                                    <a href="edit_medicine.php?id=<?php echo $medicine['id']; ?>">Edit</a>
                                    <a href="delete_medicine.php?id=<?php echo $medicine['id']; ?>">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">Tidak ada data obat yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Tombol untuk tambah obat -->
        <?php if ($loggedIn) : ?>
            <ul>
                <li><a href="add_medicine.php">Tambah Obat</a></li>
            </ul>

            <a href="dashboard.php" class="dashboard-button">Kembali ke Dashboard</a>
        <?php endif; ?>
    </div>

    <!-- Script untuk fungsi pencarian -->
    <script>
        function searchMedicines() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let table = document.getElementById('medicinesTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[0];
                let tdDescription = tr[i].getElementsByTagName('td')[2];
                if (tdName || tdDescription) {
                    let textValueName = tdName.textContent || tdName.innerText;
                    let textValueDescription = tdDescription.textContent || tdDescription.innerText;
                    if (textValueName.toLowerCase().indexOf(input) > -1 || textValueDescription.toLowerCase().indexOf(input) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>
</html>
