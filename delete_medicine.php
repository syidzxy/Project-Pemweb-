<?php
include 'includes/functions.php';

// Pastikan parameter id obat ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Panggil fungsi untuk melakukan soft delete
    if (deleteMedicine($id)) {
        // Redirect kembali ke halaman medicines.php setelah menghapus obat
        header("Location: medicines.php");
        exit();
    } else {
        echo "Gagal menghapus obat.";
    }
} else {
    echo "ID obat tidak ditemukan.";
}
?>
