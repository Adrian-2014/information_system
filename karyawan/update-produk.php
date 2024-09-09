<?php

session_start();

include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Cek apakah kode produk sudah ada di database untuk produk lain
    $check_sql = "SELECT * FROM produk WHERE kode = '$kode' AND id != '$id'";
    $result = mysqli_query($connect, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Jika ada produk lain dengan kode yang sama, kirim feedback ke user
        $_SESSION['message'] = 'Kode produk sudah ada untuk produk lain!';
        $_SESSION['type'] = 'error';
        $_SESSION['head'] = 'Gagal';

        header('Location: index.php'); // Redirect kembali ke halaman edit
        exit();
    } else {
        // Proses upload gambar jika ada file yang diupload
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "../uploads/";
            $gambar_asli = basename($_FILES["gambar"]["name"]);
            $imageFileType = strtolower(pathinfo($gambar_asli, PATHINFO_EXTENSION));

            // Tambahkan timestamp pada nama file sebelum ekstensi
            $timestamp = time(); // Mendapatkan timestamp saat ini
            $gambar_baru = pathinfo($gambar_asli, PATHINFO_FILENAME) . '_' . $timestamp . '.' . $imageFileType;
            $target_file = $target_dir . $gambar_baru;

            // Pindahkan file ke folder tujuan
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Hapus gambar lama jika ada
                $query_select = "SELECT gambar FROM produk WHERE id = '$id'";
                $result_select = mysqli_query($connect, $query_select);
                if ($result_select && mysqli_num_rows($result_select) > 0) {
                    $row = mysqli_fetch_assoc($result_select);
                    $gambar_lama = $row['gambar'];
                    if (file_exists($target_dir . $gambar_lama)) {
                        unlink($target_dir . $gambar_lama);
                    }
                }

                // Update data produk termasuk gambar baru
                $sql = "UPDATE produk SET nama='$nama', kode='$kode', harga='$harga', stok='$stok', gambar='$gambar_baru' WHERE id='$id'";
            } else {
                echo "Gagal mengupload gambar.";
                exit;
            }
        } else {
            // Update data produk tanpa mengubah gambar
            $sql = "UPDATE produk SET nama='$nama', kode='$kode', harga='$harga', stok='$stok' WHERE id='$id'";
        }

        // Jalankan query untuk update data
        if (mysqli_query($connect, $sql)) {
            $_SESSION['message'] = "Produk berhasil diupdate!";
            $_SESSION['type'] = 'success';
            $_SESSION['head'] = 'Sukses';

            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
    }
}
?>
