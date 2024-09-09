<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<?php
include '../conn.php';

$karyawan = mysqli_query($connect, 'SELECT * FROM karyawan ORDER BY id DESC');
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
    <title>Laporan - Admin <?= $_SESSION['role'] ?></title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/laporan.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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
                <div class="container-fluid px-5">
                    <h1 class="mt-4">Laporan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">- Data Laporan Harian -</li>
                    </ol>
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Laporan Harian
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Pelapor</th>
                                        <th>Produk</th>
                                        <th>Produk Terjual</th>
                                        <th>Tanggal Laporan</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Pelapor</th>
                                        <th>Produk</th>
                                        <th>Produk Terjual</th>
                                        <th>Tanggal Laporan</th>
                                        <th>Detail</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $no = 1;
                                        while($lapor = mysqli_fetch_array($laporan)) :
                                        $code = $lapor['kode_produk'];
                                        $idP = $lapor['id_pelapor'];
                                        $gambar_result = mysqli_query($connect, "SELECT gambar FROM produk WHERE kode = '$code' LIMIT 1");
                                        $gambar_data = mysqli_fetch_array($gambar_result);
                                        $gambar = $gambar_data['gambar'];

                                        $tanggal_laporan = new DateTime($lapor['tanggal_laporan']);
                                        $tanggal_dikirim = new DateTime($lapor['tanggal_ditambahkan']);

                                        $karyawanConnect = mysqli_query($connect, "SELECT * FROM karyawan WHERE id = '$idP'");
                                        $karyawanData = mysqli_fetch_array($karyawanConnect);

                                        $class = !$karyawanData ? "dipecat" : "";

                                        ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $lapor['pelapor'] ?></td>
                                        <td><?= $lapor['produk'] ?></td>
                                        <td><?= $lapor['terjual'] ?> pcs</td>
                                        <td><?= $tanggal_laporan->format('d F Y') ?></td>
                                        <td>
                                            <div class="btn" data-bs-toggle="modal" data-bs-target="#detail<?= $lapor['id'] ?>">
                                                <i class="bi bi-eye"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal -->

                                    <div class="modal fade" id="detail<?= $lapor['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="first-content">
                                                        <div class="imgs">
                                                            <img src="../uploads/<?= $gambar ?>">
                                                        </div>
                                                        <div class="isi <?= $class; ?>">
                                                            <div class="head">
                                                                <div class="first">Data Pelapor</div>
                                                                <div class="last"><i class="bi bi-person-fill"></i></div>
                                                            </div>
                                                            <div class="main">
                                                                <div class="mb-2">
                                                                    <label class="form-label">Pelapor</label>
                                                                    <input type="text" class="form-control" value="<?= $lapor['pelapor'] ?>" readonly>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label">Email Pelapor</label>
                                                                    <input type="text" class="form-control" value="<?= $lapor['email_pelapor'] ?>" readonly>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label class="form-label">No. Telepon</label>
                                                                    <input type="text" class="form-control" value="<?= $lapor['no_telp_pelapor'] ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="gaps">

                                                    </div>
                                                    <div class="second-content">
                                                        <div class="head">
                                                            <div class="first">Data Laporan Produk</div>
                                                            <div class="last"><i class="bi bi-box"></i></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 mb-2">
                                                                <label class="form-label">Nama Produk</label>
                                                                <input type="text" class="form-control" value="<?= $lapor['produk'] ?>" readonly>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <label class="form-label">Kode Produk</label>
                                                                <input type="text" class="form-control" value="<?= $lapor['kode_produk'] ?>" readonly>
                                                            </div>
                                                            <div class="col-4 mb-2">
                                                                <label class="form-label">Produk Terjual</label>
                                                                <input type="text" class="form-control" value="<?= $lapor['terjual'] ?> pcs" readonly>
                                                            </div>
                                                            <div class="col-6 mb-2">
                                                                <label class="form-label">Tanggal Laporan</label>
                                                                <input type="text" class="form-control" value="<?= $tanggal_laporan->format('d F Y') ?>" readonly>
                                                            </div>
                                                            <div class="col-6 mb-2">
                                                                <label class="form-label">Tanggal Dikirim</label>
                                                                <input type="text" class="form-control" value="<?= $tanggal_dikirim->format('d F Y') ?>" readonly>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->

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
