<?php

session_start();

include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $target_dir = '../uploads/';
    $gambar_asli = basename($_FILES['gambar']['name']);
    $imageFileType = strtolower(pathinfo($gambar_asli, PATHINFO_EXTENSION));
    $timestamp = time();
    $gambar_baru = pathinfo($gambar_asli, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
    $target_file = $target_dir . $gambar_baru;

    // Cek apakah kode produk sudah ada di database
    $check_sql = "SELECT * FROM produk WHERE kode = '$kode'";
    $result = mysqli_query($connect, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Jika ada kode yang sama, kirim feedback ke user
        $_SESSION['message'] = 'Kode produk sudah ada, harap masukkan kode lain!';
        $_SESSION['type'] = 'error';
        $_SESSION['head'] = 'Gagal';

        header('Location: index.php'); // Redirect kembali ke form tambah produk
        exit();
    } else {
        // Jika tidak ada duplikasi kode, lanjutkan dengan upload gambar dan insert data
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Insert data ke database
            $sql = "INSERT INTO produk (nama, kode, harga, stok, gambar)
                    VALUES ('$nama', '$kode', '$harga', '$stok', '$gambar_baru')";

            if (mysqli_query($connect, $sql)) {
                $_SESSION['message'] = 'Produk berhasil ditambahkan!';
                $_SESSION['type'] = 'success';
                $_SESSION['head'] = 'Sukses';

                header('Location: index.php');
                exit();
            } else {
                echo 'Error: ' . $sql . '<br>' . mysqli_error($connect);
            }
        } else {
            echo 'Gagal mengupload gambar.';
        }
    }
}
?>
