<?php

session_start();

include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $no_telp = $_POST['no_telp'];
    $kantor = 'kenjeran';

    // Update data produk termasuk gambar baru
    $sql = "UPDATE karyawan SET nama='$nama', usia='$usia', email='$email', kode='$password', nomor_telepon='$no_telp', kantor='$kantor' WHERE id='$id'";

    // Jalankan query untuk update data
    if (mysqli_query($connect, $sql)) {
        $_SESSION['message'] = 'Data Karyawan berhasil diupdate!';
        $_SESSION['type'] = 'success';

        header('Location: index.php');
        exit();
    } else {
        echo 'Error: ' . $sql . '<br>' . mysqli_error($connect);
    }
}
?>
