<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>


<?php
include '../conn.php';

$products = mysqli_query($connect, 'SELECT * FROM produk ORDER BY id DESC');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/produk.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                        <a class="nav-link" href="produk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                            Produk
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Data Produk Nova Mart -</li>
                    </ol>
                    <div class="row lists">

                        <?php while($produk = mysqli_fetch_array($products)) : ?>

                        <div class="col-3">
                            <div class="item">
                                <div class="img-content">
                                    <img src="../uploads/<?= $produk['gambar'] ?>">
                                </div>
                                <div class="contain">
                                    <div class="main">
                                        <div class="main-context">
                                            <div class="nama">
                                                <?= $produk['nama'] ?>
                                            </div>
                                        </div>
                                        <div class="harga">
                                            Rp. <?= $produk['harga'] ?>
                                        </div>
                                    </div>
                                    <div class="act">
                                        <div class="detail" data-bs-toggle="modal" data-bs-target="#detail<?= $produk['id'] ?>">
                                            <i class="bi bi-eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="detail<?= $produk['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="img-content">
                                            <img src="../uploads/<?= $produk['gambar'] ?>">
                                        </div>
                                        <div class="isi">
                                            <div class="head">
                                                <div class="first">Data Produk</div>
                                                <div class="last"><i class="bi bi-box"></i></div>
                                            </div>
                                            <div class="main">
                                                <div class="mb-2">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" class="form-control" value="<?= $produk['nama'] ?>" readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Kode Produk</label>
                                                    <input type="text" class="form-control" value="<?= $produk['kode'] ?>" readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Harga Produk</label>
                                                    <input type="text" class="form-control" value="<?= $produk['harga'] ?>" readonly>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Stok Tersisa</label>
                                                    <input type="text" class="form-control" value="<?= $produk['stok'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php endwhile; ?>
                    </div>
                </div>
            </main>
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


</body>

</html>
