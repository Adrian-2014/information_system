<?php
session_start();
include '../conn.php'; // Hubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa admin
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['nama'] = $admin['nama'];
        $_SESSION['id'] = $admin['id'];
        $_SESSION['role'] = 'admin';
        $_SESSION['message'] = "Login berhasil sebagai Admin!";
        $_SESSION['type'] = "success";
        // $_SESSION['type'] = "success";
        header("Location: ../admin/index.php");
    } else {
        $_SESSION['message'] = "Login gagal. Email atau password salah.";
        $_SESSION['type'] = "error";
        header("Location: ../index.php");
    }
    exit;
}
?>
