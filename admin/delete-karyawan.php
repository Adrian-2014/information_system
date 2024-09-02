<?php
// Sertakan file koneksi ke database
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Hapus data produk dari database
    $query_delete = "DELETE FROM karyawan WHERE id = '$id'";
    if (mysqli_query($connect, $query_delete)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
