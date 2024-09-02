<?php

session_start();

include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $no_telp = $_POST['no_telp'];
    $kantor = 'kenjeran';

    $sql = "INSERT INTO karyawan (nama, usia, email, kode, nomor_telepon, kantor) VALUES ('$nama', '$usia', '$email', '$password', '$no_telp', '$kantor')";

    if (mysqli_query($connect, $sql)) {
        $_SESSION['message'] = 'Karyawan berhasil ditambahkan!';
        $_SESSION['type'] = 'success';

        header('Location: index.php');
        exit();
    } else {
        echo 'Error: ' . $sql . '<br>' . mysqli_error($connect);
    }
}
?>
