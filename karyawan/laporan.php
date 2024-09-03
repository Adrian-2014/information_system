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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Laporan Produk -</li>
                    </ol>

                    <div class="row laporan">
                        <div class="col-3">
                            
                        </div>
                    </div>
                </div>
            </main>

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
