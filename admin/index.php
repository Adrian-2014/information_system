<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    header('Location: ../index.php');
    exit();
}
?>


<?php
include '../conn.php';

$karyawan = mysqli_query($connect, 'SELECT * FROM karyawan ORDER BY id DESC');
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
    <link href="css/custom.css" rel="stylesheet" />

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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Data Karyawan -</li>
                    </ol>
                    <!-- <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Daftar Produk Nova Mart</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Lihat lebih detail</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Daftar Laporan Karyawan Nova Mart</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Lihat lebih detail</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="tambahkan">
                        <div class="trigger" data-bs-toggle="modal" data-bs-target="#tambahkeun">
                            <i class="bi bi-plus-square"></i>
                            <div class="txt">
                                Tambah Karyawan
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Karyawan Nova Mart
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Usia</th>
                                        <th>Email</th>
                                        <th>No. Telephone</th>
                                        <th>Tanggal / Waktu Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Usia</th>
                                        <th>Email</th>
                                        <th>No. Telephone</th>
                                        <th>Tanggal / Waktu Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php while($work = mysqli_fetch_array($karyawan)) :

                                        $start = new DateTime($work['tanggal_ditambahkan'])
                                        ?>
                                    <tr>
                                        <td><?= $work['nama'] ?></td>
                                        <td><?= $work['usia'] ?> Tahun</td>
                                        <td><?= $work['email'] ?></td>
                                        <td><?= $work['nomor_telepon'] ?></td>
                                        <td><?= $start->format('d F Y - H:i') ?></td>
                                        <td>
                                            <div class="special">
                                                <div class="editz" data-bs-toggle="modal" data-bs-target="#editz<?= $work['id'] ?>">
                                                    <i class="bi bi-pencil-square"></i>
                                                </div>
                                                <div class="hapustomlol" id="<?= $work['id'] ?>">
                                                    <i class="bi bi-trash3"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editz<?= $work['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data <?= $work['nama'] ?></h1>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="update-karyawan.php" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?= $work['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" name="nama" placeholder="nama lengkap.." required value="<?= $work['nama'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="email.."required value="<?= $work['email'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">No. Telepon</label>
                                                            <input type="text" class="form-control" name="no_telp" placeholder="nomor telepon.."required value="<?= $work['nomor_telepon'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                                                            <input type="text" class="form-control" name="password" placeholder="password.."required value="<?= $work['password'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Usia</label>
                                                            <input type="number" class="form-control" name="usia" placeholder="usia.." required value="<?= $work['usia'] ?>" x-on:keydown.prevent min="18">
                                                        </div>
                                                        <div class="mb-1 mt-3">
                                                            <button type="submit" class="add">
                                                                Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Tambah Karyawan -->

    <div class="modal fade" id="tambahkeun" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Karyawan</h1>
                </div>
                <div class="modal-body">
                    <form action="tambah-karyawan.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" placeholder="nama lengkap.." required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="email.."required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telp" placeholder="nomor telepon.."required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input type="text" class="form-control" name="password" placeholder="password.."required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Usia</label>
                            <input type="number" class="form-control" name="usia" placeholder="usia.."required x-on:keydown.prevent min="18">
                        </div>
                        <div class="mb-1 mt-3">
                            <button type="submit" class="add">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Tambah Karyawan -->

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
        document.querySelector("tbody").addEventListener("click", function(event) {
            if (event.target.closest(".hapustomlol")) {
                var productId = event.target.closest(".hapustomlol").id;
                Swal.fire({
                    title: "Kamu Yakin?",
                    text: "Data akan dihapus secara permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('delete-karyawan.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `id=${productId}`
                            }).then(response => response.text())
                            .then(data => {
                                if (data === 'success') {
                                    Swal.fire({
                                        title: "Dihapus!",
                                        text: "Data berhasil dihapus.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                                }
                            })
                            .catch(error => {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                            });
                    }
                });
            }
        });
    </script>
</body>

</html>
