<?php
include 'includes/functions.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // Check if medicine quantity is sufficient
    $medicine_query = mysqli_query($DB, "SELECT quantity FROM medicines WHERE id = '$medicine_id'");
    $medicine = mysqli_fetch_assoc($medicine_query);

    if ($medicine['quantity'] >= $quantity) {
        // Insert into patients table
        $sql = "INSERT INTO patients (name, medicine_id, quantity) VALUES ('$name', '$medicine_id', '$quantity')";
        if (mysqli_query($DB, $sql) === TRUE) {
            // Update medicine quantity
            $new_quantity = $medicine['quantity'] - $quantity;
            mysqli_query($DB, "UPDATE medicines SET quantity = '$new_quantity' WHERE id = '$medicine_id'");
            echo "berhasil!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($DB);
        }
    } else {
        echo "Jumlah obat tidak mencukupi!";
    }
}

$medicines = mysqli_query($DB, "SELECT * FROM medicines");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemberian Obat</title>
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
        }

        input[type="text"],
        input[type="number"],
        select {
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
        <h1>Form Pemberian Obat</h1>
        <form method="post" action="patient_presence.php">
            <input type="text" name="name" placeholder="Nama Pasien" required>
            <select name="medicine_id" required>
                <option value="">Pilih Obat</option>
                <?php while ($medicine = mysqli_fetch_assoc($medicines)) : ?>
                    <option value="<?php echo $medicine['id']; ?>"><?php echo $medicine['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="quantity" placeholder="Jumlah" required>
            <button type="submit">Tambah</button>
        </form>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
