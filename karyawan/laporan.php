<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'karyawan'){
    header('Location: ../index.php');
    exit();
}
?>

<?php

include '../conn.php';

$products = mysqli_query($connect, 'SELECT * FROM produk ORDER BY id DESC');
$laporan = mysqli_query($connect, 'SELECT * FROM laporan ORDER BY id DESC');

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - Karyawan </title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/laporan.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Nova Mart</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="greet">
            <?= $_SESSION['nama'] ?>
        </div>

        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../index.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="laporan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-word"></i></div>
                            Laporan
                        </a>
                        <!-- <div class="sb-sidenav-menu-heading">Lainnya</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Akun
                        </a> -->
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content" class="mains">
            <!-- MAIN SECTION -->
            <main>
                <div class="container-fluid px-5">
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Laporan Harian -</li>
                    </ol>

                    <div class="row first">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <div class="trigger" data-bs-toggle="modal" data-bs-target="#laporkeun">
                                <i class="bi bi-pencil"></i>
                                <div class="txt">
                                    Buat Laporan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Riwayat Laporan Kamu
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Kode Produk</th>
                                        <th>gambar Produk</th>
                                        <th>Produk Terjual</th>
                                        <th>Tanggal Laporan</th>
                                        <th>Tanggal Dikirim</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Kode Produk</th>
                                        <th>gambar Produk</th>
                                        <th>Produk Terjual</th>
                                        <th>Tanggal Laporan</th>
                                        <th>Tanggal Dikirim</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $no = 1; // Inisialisasi sebelum loop
                                        while($lapor = mysqli_fetch_array($laporan)) :
                                        // Mendapatkan gambar
                                        $code = $lapor['kode_produk'];
                                        $gambar_result = mysqli_query($connect, "SELECT gambar FROM produk WHERE kode = '$code' LIMIT 1");
                                        $gambar_data = mysqli_fetch_array($gambar_result);
                                        $gambar = $gambar_data['gambar'];

                                        $tanggal_laporan = new DateTime($lapor['tanggal_laporan']);
                                        $tanggal_dikirim = new DateTime($lapor['tanggal_ditambahkan']);
                                        ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $lapor['produk'] ?></td>
                                        <td><?= $lapor['kode_produk'] ?></td>
                                        <td><img src="../uploads/<?= $gambar ?>"></td>
                                        <td><?= $lapor['terjual'] ?> pcs</td>
                                        <td><?= $tanggal_laporan->format('d F Y') ?></td>
                                        <td><?= $tanggal_dikirim->format('d F Y') ?></td>
                                    </tr>

                                    <?php
                                        $no++;
                                        endwhile;
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <div class="modal fade" id="laporkeun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Laporan</h1>
                </div>
                <div class="modal-body">
                    <form action="kirim-laporan.php" method="post" enctype="multipart/form-data" x-data="{ selectedProduct: '', stok: 0, id_pro: '', kode_produk: '' }">
                        <input type="hidden" name="pelapor" value="<?= $_SESSION['nama'] ?>">
                        <input type="hidden" name="id_pelapor" value="<?= $_SESSION['id'] ?>">
                        <input type="hidden" name="produk_id" :value="id_pro">
                        <input type="hidden" name="produk_stok" :value="stok">
                        <input type="hidden" name="kode_produk" :value="kode_produk">

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tanggal Laporan</label>
                            <input type="date" class="form-control" id="date" name="tanggal" placeholder="tanggal laporan.." required>
                        </div>
                        <div class="mb-3 special">
                            <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                            <div class="for-produk">
                                <input type="text" class="form-control" readonly name="nama" placeholder="nama produk.." x-model="selectedProduct" required>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php while($item = mysqli_fetch_array($products)) : ?>
                                        <li @click="selectedProduct = '<?= $item['nama'] ?>'; stok = <?= $item['stok'] ?>; id_pro = <?= $item['id'] ?>; kode_produk = '<?= $item['kode'] ?>';">
                                            <div class="item">
                                                <div class="img-content">
                                                    <img src="../uploads/<?= $item['gambar'] ?>">
                                                </div>
                                                <div class="name"><?= $item['nama'] ?></div>
                                            </div>
                                        </li>
                                        <?php endwhile; ?>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3" x-show="selectedProduct !== ''">
                            <label for="exampleFormControlInput1" class="form-label">Produk Terjual</label>
                            <input type="number" class="form-control" name="terjual" placeholder="produk terjual.." min="0" :max="stok" x-on:keydown.prevent required>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="add">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


    <script>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Januari dimulai dari 0
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('date').max = today;
    </script>


    <?php
    if (isset($_SESSION['message']) && isset($_SESSION['type'])) {
        echo "<script>
                                                        Swal.fire({
                                                            title: 'Sukses!',
                                                            text: '" .
            $_SESSION['message'] .
            "',
                                                            icon: '" .
            $_SESSION['type'] .
            "',
                                                            confirmButtonText: 'OK'
                                                        });
                                                    </script>";
        unset($_SESSION['message']);
        unset($_SESSION['type']);
    }
    ?>

    <script>
        var triggerBtn = document.querySelectorAll(".hapustombol");
        triggerBtn.forEach(function(button) {
            button.addEventListener("click", function() {
                var productId = this.id;
                Swal.fire({
                    title: "Kamu Yakin?",
                    text: "Data akan di Hapus secara permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, kirim request untuk menghapus data
                        fetch('delete-produk.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `id=${productId}`
                            })
                            .then(response => response.text())
                            .then(data => {
                                if (data === 'success') {
                                    Swal.fire({
                                        title: "Dihapus!",
                                        text: "Produk berhasil dihapus.",
                                        icon: "success"
                                    }).then(() => {
                                        // Refresh halaman atau hapus elemen dari DOM
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error!", "Terjadi kesalahan saat menghapus produk.", "error");
                                }
                            })
                            .catch(error => {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus produk.", "error");
                            });
                    }
                });
            });
        });
    </script>
</body>

</html>
