<?php

session_start();

include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $no_telp = $_POST['no_telp'];

    // Cek apakah email sudah ada di database
    $check_sql = "SELECT * FROM karyawan WHERE email = '$email'";
    $result = mysqli_query($connect, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Jika email sudah ada, kirim feedback ke user
        $_SESSION['message'] = 'Email sudah digunakan, harap masukkan email lain!';
        $_SESSION['type'] = 'error';
        $_SESSION['head'] = 'Gagal';

        header('Location: index.php'); // Redirect kembali ke form tambah karyawan
        exit();
    } else {
        // Jika tidak ada duplikasi, lakukan insert data
        $sql = "INSERT INTO karyawan (nama, usia, email, password, nomor_telepon) VALUES ('$nama', '$usia', '$email', '$password', '$no_telp')";

        if (mysqli_query($connect, $sql)) {
            $_SESSION['message'] = 'Karyawan berhasil ditambahkan!';
            $_SESSION['type'] = 'success';
            $_SESSION['head'] = 'Sukses';

            header('Location: index.php');
            exit();
        } else {
            echo 'Error: ' . $sql . '<br>' . mysqli_error($connect);
        }
    }
}
?>

