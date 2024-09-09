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

    // Cek apakah email sudah ada di database untuk karyawan lain
    $check_sql = "SELECT * FROM karyawan WHERE email = '$email' AND id != '$id'";
    $result = mysqli_query($connect, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Jika email sudah digunakan oleh karyawan lain
        $_SESSION['message'] = 'Email ini sudah digunakan, harap gunakan email lain!';
        $_SESSION['type'] = 'error';
        $_SESSION['head'] = 'Gagal';

        header('Location: edit_karyawan.php?id=' . $id);
        exit();
    } else {
        // Jika tidak ada duplikasi, lakukan update data karyawan
        $sql = "UPDATE karyawan SET nama='$nama', usia='$usia', email='$email', password='$password', nomor_telepon='$no_telp' WHERE id='$id'";

        // Jalankan query untuk update data
        if (mysqli_query($connect, $sql)) {
            $_SESSION['message'] = 'Data Karyawan berhasil diupdate!';
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

