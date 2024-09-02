<?php
// Sertakan file koneksi ke database
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Ambil nama file gambar dari database sebelum dihapus
    $query_select = "SELECT gambar FROM produk WHERE id = '$id'";
    $result_select = mysqli_query($connect, $query_select);
    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $gambar = $row['gambar'];
        $target_file = "../uploads/" . $gambar;

        // Hapus gambar dari folder uploads
        if (file_exists($target_file)) {
            unlink($target_file);
        }
    }

    // Hapus data produk dari database
    $query_delete = "DELETE FROM produk WHERE id = '$id'";
    if (mysqli_query($connect, $query_delete)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
