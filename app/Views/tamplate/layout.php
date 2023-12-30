<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Absensi dan Gaji - MA. Advertising</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url() ?>/assets/img/logomabaru.png" rel="icon">
    <link href="<?= base_url() ?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url() ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet">

    <!-- jquery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- notifikasi sukses keren sweeet alert -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url() ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body id="body">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <a style="margin-left: 10px;"> </a>
            <a href="<?= base_url('Home/index'); ?>" class="logo d-flex align-items-center">
                <img src="<?= base_url() ?>/assets/img/logomaadv.png" alt="">
                <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
            </a>

        </div><!-- End Logo -->

        <!-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div> -->
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">




                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                        <img style="max-height: 1rem;" src="<?= base_url() ?>/assets/img/downlogo.png" alt="Profile"
                            class="rounded">
                        <span class="d-none d-md-block ps-2"><?= session()->namauser ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= session()->namauser ?></h6>
                            <span>
                                <?php if (session()->idlevel == 1) : ?>
                                Admin
                                <?php elseif (session()->idlevel == 2) : ?>
                                Pimpinan
                                <?php endif ?>


                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('Login/Keluar'); ?>">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <?php if (session()->idlevel == 1) : ?>

        <ul class="sidebar-nav" id="sidebar-nav">



            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('Home/index'); ?>" id="beranda">
                    <i class="bi bi-grid"></i>
                    <span>Beranda</span>
                </a>
            </li><!-- End Dashboard Nav -->




            <li class="nav-item">
                <a class="nav-link collapsed" id="karyawan" data-bs-target="#components-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Karyawan</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Karyawan/index'); ?>" id="daftrakaryawan">
                            <i class="bi bi-circle"></i><span>Daftar Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Karyawan/tambah'); ?>" id="tambahkaryawan">
                            <i class="bi bi-circle"></i><span>Input Data Karyawan</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="pengguna" data-bs-target="#Pengguna-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-person-lines-fill"></i><span>Pengguna</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Pengguna-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('User/index'); ?>" id="daftrapengguna">
                            <i class="bi bi-circle"></i><span>Daftar Pengguna</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('User/tambah'); ?>" id="tambahpengguna">
                            <i class="bi bi-circle"></i><span>Input Data Pengguna</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="lokasi" href="<?= base_url('LokasiKantor/index'); ?>">
                    <i class="bi bi-geo-alt"></i><span>Lokasi Kantor</span></i>
                </a>

            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" id="Jamkerja" href="<?= base_url('Jamkerja/index'); ?>">
                    <i class="bi bi-alarm"></i><span>Jam Kerja</span></i>
                </a>

            </li><!-- End Components Nav -->





            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#absensi-nav" data-bs-toggle="collapse" href="#"
                    id="absensi">
                    <i class="bi bi-calendar3"></i><span>Absensi</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="absensi-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Absensi/tambah'); ?>" id="inputabsensi">
                            <i class="bi bi-circle"></i><span>Input Data Absensi Masuk </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('Absensi/tambahpulang'); ?>" id="formtambahabsensipulang">
                            <i class="bi bi-circle"></i><span>Input Data Absensi Pulang </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('Absensi/tambahizin'); ?>" id="izin">
                            <i class="bi bi-circle"></i><span>Input Data Absensi Izin </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Absensi/index'); ?>" id="daftarabsensi">
                            <i class="bi bi-circle"></i><span>Daftar Absensi</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Absensi/dataperbulan'); ?>" id="dataabsensiperbulan">
                            <i class="bi bi-circle"></i><span>Data Absensi Perbulan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Absensi/dataabsensiperhari'); ?>" id="dataabsensiperhari">
                            <i class="bi bi-circle"></i><span>Data Absensi Perhari</span>
                        </a>
                    </li>




                </ul>
            </li><!-- End Forms Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#lembur-nav" data-bs-toggle="collapse" href="#"
                    id="lembur">
                    <i class="bi bi-journal-text"></i><span>Lembur</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="lembur-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Lembur/tambah'); ?>" id="inputdatalembur">
                            <i class="bi bi-circle"></i><span>Input Data Lembur</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Lembur/index'); ?>" id="datalembur">
                            <i class="bi bi-circle"></i><span>Data Lembur</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Lembur/dataperbulan'); ?>" id="datalemburperbulan">
                            <i class="bi bi-circle"></i><span>Data Lembur Perbulan</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#hutang-nav" data-bs-toggle="collapse" href="#"
                    id="hutang">
                    <i class="bi bi-journal-text"></i><span>Hutang</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="hutang-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Hutang/tambah'); ?>" id="inputdatahutang">
                            <i class="bi bi-circle"></i><span>Input Data Hutang</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Hutang/index'); ?>" id="datahutang">
                            <i class="bi bi-circle"></i><span>Data Hutang</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Hutang/datahutangperbulan'); ?>" id="datahutangperbulan">
                            <i class="bi bi-circle"></i><span>Data Hutang Perbulan</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Tables Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#kelalaian-nav" data-bs-toggle="collapse" href="#"
                    id="kelalaian">
                    <i class="bi bi-journal-text"></i><span>Kelalaian</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="kelalaian-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Kelalaian/tambah'); ?>" id="inputdatakelalaian">
                            <i class="bi bi-circle"></i><span>Input Data Kelalaian</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Kelalaian/index'); ?>" id="datakelalaian">
                            <i class="bi bi-circle"></i><span>Data Kelalaian</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Kelalaian/dataperbulan'); ?>" id="datakelalaianperbulan">
                            <i class="bi bi-circle"></i><span>Data Kelalaian Perbulan</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Tables Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#gaji-nav" data-bs-toggle="collapse" href="#" id="gaji">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Penggajian</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="gaji-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Penggajian/tambah'); ?>" id="tambahgaji">
                            <i class="bi bi-circle"></i><span>Rekap Data Gaji</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('Penggajian/dataperbulan'); ?>" id="datagajiperbulan">
                            <i class="bi bi-circle"></i><span>Data Gaji</span>
                        </a>
                    </li>


                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#laporan-nav" id="laporan" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-bar-chart"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="laporan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Laporan/laporandatakaryawan'); ?>" target="_blank">
                            <i class="bi bi-circle"></i><span>Laporan Data Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporanabsensikaryawan'); ?>" id="laporanabsensi">
                            <i class="bi bi-circle"></i><span>Laporan Absensi Karyawan </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporanhutangkaryawan'); ?>" id="laporanhutang">
                            <i class="bi bi-circle"></i><span>Laporan Hutang Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporankalalaiankaryawan'); ?>" id="laporankalalaian">
                            <i class="bi bi-circle"></i><span>Laporan Kelalaian Karyawan </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporangajikaryawan'); ?>" id="laporangaji">
                            <i class="bi bi-circle"></i><span>Laporan Gaji Karyawan </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('Laporan/laporanlemburkaryawan'); ?>" id="laporanlemburkaryawan">
                            <i class="bi bi-circle"></i><span>Laporan Lembur Karyawan </span>
                        </a>
                    </li>




                </ul>
            </li><!-- End Charts Nav -->



        </ul>

        <?php elseif (session()->idlevel == 2) : ?>

        <ul class="sidebar-nav" id="sidebar-nav">



            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('Home/index'); ?>" id="beranda">
                    <i class="bi bi-grid"></i>
                    <span>Beranda</span>
                </a>
            </li><!-- End Dashboard Nav -->





            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#gaji-nav" data-bs-toggle="collapse" href="#" id="gaji">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Penggajian</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="gaji-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">


                    <li>
                        <a href="<?= base_url('Penggajian/inputbonus'); ?>" id="inputbonus">
                            <i class="bi bi-circle"></i><span>Input Bonus & Accept Gaji</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#laporan-nav" id="laporan" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-bar-chart"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="laporan-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= base_url('Laporan/laporandatakaryawan'); ?>" target="_blank">
                            <i class="bi bi-circle"></i><span>Laporan Data Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporanabsensikaryawan'); ?>" id="laporanabsensi">
                            <i class="bi bi-circle"></i><span>Laporan Absensi Karyawan </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporanhutangkaryawan'); ?>" id="laporanhutang">
                            <i class="bi bi-circle"></i><span>Laporan Hutang Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporankalalaiankaryawan'); ?>" id="laporankalalaian">
                            <i class="bi bi-circle"></i><span>Laporan Kelalaian Karyawan </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('Laporan/laporangajikaryawan'); ?>" id="laporangaji">
                            <i class="bi bi-circle"></i><span>Laporan Gaji Karyawan </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('Laporan/laporanlemburkaryawan'); ?>" id="laporanlemburkaryawan">
                            <i class="bi bi-circle"></i><span>Laporan Lembur Karyawan </span>
                        </a>
                    </li>




                </ul>
            </li><!-- End Charts Nav -->



        </ul>

        <?php endif ?>



    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <?= $this->renderSection('judul') ?>
        <?= $this->renderSection('isi') ?>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <!-- <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
    </footer> --> -->
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url() ?>/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/echarts/echarts.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/quill/quill.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url() ?>/assets/js/main.js"></script>



</body>

</html>