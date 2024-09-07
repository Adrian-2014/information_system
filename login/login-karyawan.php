<?php
session_start();
include '../conn.php'; // Hubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa karyawan
    $sql = "SELECT * FROM karyawan WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($connect, $sql);


    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = 'karyawan';
        $_SESSION['message'] = "Login berhasil sebagai Karyawan!";
        $_SESSION['type'] = "success";
        header("Location: ../karyawan/index.php");
    } else {
        $_SESSION['message'] = "Login gagal. Email atau password salah.";
        $_SESSION['type'] = "error";
        header("Location: ../index.php");
    }
    exit;
}
?>
