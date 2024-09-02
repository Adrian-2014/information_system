<?php

include '../conn.php';

$products = mysqli_query($connect, 'SELECT * FROM produk ORDER BY id DESC');

?>

<?php
session_start();

if (!isset($_SESSION['nama'])) {
    header('Location: ../index.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Nova Mart</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="greet">
            <?php echo $_SESSION['nama']; ?>
        </div>
        <!-- Navbar Search-->
        <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form> -->
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
                        <a class="nav-link" href="index.html">
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Kelola Produk -</li>
                    </ol>

                    <div class="row first">
                        <div class="col-10"></div>
                        <div class="col-2">
                            <div class="trigger" data-bs-toggle="modal" data-bs-target="#tambahkeun">
                                <i class="bi bi-plus-square"></i>
                                <div class="txt">
                                    Tambah Produk
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product">

                        <?php while($product = mysqli_fetch_array($products)) : ?>
                        <div class="col-2">
                            <div class="img-content">
                                <img src="../uploads/<?= $product['gambar'] ?>">
                            </div>
                            <div class="contain">
                                <div class="main">
                                    <div class="nama">
                                        <?= $product['nama'] ?>
                                    </div>
                                    <div class="stok">
                                        Stok tersisa : <span><?= $product['stok'] ?></span> pcs
                                    </div>
                                </div>
                                <div class="harga">
                                    Rp. <?= $product['harga'] ?>
                                </div>
                                <div class="act">
                                    <div class="edit" data-bs-toggle="modal" data-bs-target="#editz<?= $product['id'] ?>">
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- <div class="txt">Edit</div> -->
                                    </div>
                                    <div class="hapustombol" id="<?= $product['id'] ?>">
                                        <i class="bi bi-trash3"></i>
                                        <!-- <div class="txt">Edit</div> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editz<?= $product['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data <?= $product['nama'] ?></h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="update-produk.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" name="nama" placeholder="nama produk.." required value="<?= $product['nama'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Kode Produk</label>
                                                <input type="text" class="form-control" name="kode" placeholder="kode produk.."required value="<?= $product['kode'] ?>">
                                            </div>
                                            <div class="mb-3 special">
                                                <label for="exampleFormControlInput1" class="form-label">Harga Produk</label>
                                                <div class="numeric">
                                                    <div class="harga">
                                                        Rp.
                                                    </div>
                                                    <input type="number" class="form-control" name="harga" placeholder="harga produk.."required value="<?= $product['harga'] ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Stok</label>
                                                <input type="number" class="form-control" name="stok" placeholder="stok produk.."required value="<?= $product['stok'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">gambar Produk</label>
                                                <input type="file" name="gambar" accept="image/jpg, image/jpeg, image/png" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="mb-2 mt-4">
                                                <button type="submit" class="add">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit -->
                        <?php endwhile; ?>
                    </div>
                </div>
            </main>
            <!-- MAIN SECTION -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; NovaMart 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahkeun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                </div>
                <div class="modal-body">
                    <form action="tambah-produk.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama" placeholder="nama produk.." required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" name="kode" placeholder="kode produk.."required>
                        </div>
                        <div class="mb-3 special">
                            <label for="exampleFormControlInput1" class="form-label">Harga Produk</label>
                            <div class="numeric">
                                <div class="harga">
                                    Rp.
                                </div>
                                <input type="number" class="form-control" name="harga" placeholder="harga produk ($)"required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" placeholder="stok produk.."required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">gambar Produk</label>
                            <input type="file" name="gambar" accept="image/jpg, image/jpeg, image/png" class="form-control" id="exampleFormControlInput1" required>
                        </div>
                        <div class="mb-2 mt-4">
                            <button type="submit" class="add">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Tambah -->

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


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
