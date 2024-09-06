<?php

session_start();

include '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelapor = $_POST['pelapor'];
    $id_pelapor = $_POST['id_pelapor'];
    $nama_produk = $_POST['nama'];
    $produk_terjual = (int)$_POST['terjual']; // Casting to integer
    $tanggal_laporan = $_POST['tanggal'];

    $produk_stok = (int)$_POST['produk_stok']; // Casting to integer
    $id_produk = $_POST['produk_id'];
    $kode_produk = $_POST['kode_produk'];

    // Hitung stok baru
    $calc = $produk_stok - $produk_terjual;

    // Query untuk insert laporan
    $sql_insert = "INSERT INTO laporan (pelapor, id_pelapor, produk, terjual, tanggal_laporan, kode_produk)
                   VALUES ('$pelapor', '$id_pelapor', '$nama_produk', '$produk_terjual', '$tanggal_laporan', '$kode_produk')";

    // Query untuk update stok
    $sql_update = "UPDATE produk SET stok='$calc' WHERE id = '$id_produk'";

    // Eksekusi kedua query
    if (mysqli_query($connect, $sql_insert) && mysqli_query($connect, $sql_update)) {
        $_SESSION['message'] = 'Laporan Berhasil Dikirim!';
        $_SESSION['type'] = 'success';

        header('Location: laporan.php');
        exit();
    } else {
        echo 'Error: ' . mysqli_error($connect);
    }
}
