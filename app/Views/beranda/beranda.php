<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <h1>Beranda</h1>
    <nav>
        <ol class="breadcrumb">
            <!-- <li class="breadcrumb-item"><a href="index.html">Home</a></li> -->
            <li class="breadcrumb-item active">Beranda</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Menu</h6>
                                </li>

                                <li><a class="dropdown-item" href="<?= base_url('Hutang/datahutangperbulan'); ?>">Data
                                        Hutang</a></li>

                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Hutang Karyawan <span>| Bulan Ini</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Rp.
                                        <?= number_format($totalpinajam, 0) ?></h6>
                                    <span class="text-success small pt-1 fw-bold"><?= $jumlahpinjaman ?> </span> <span
                                        class="text-muted small pt-2 ps-1">Pinjaman</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-6 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Menu</h6>
                                </li>

                                <li><a class="dropdown-item" href=" <?= base_url('Kelalaian/dataperbulan'); ?>">Data
                                        Kelalaian</a></li>

                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Potongan Kelalaian <span>| Bulan Ini</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>Rp.
                                        <?= number_format($totallalai, 0) ?></h6>
                                    <span class="text-success small pt-1 fw-bold"><?= $jumlahkelalaian ?> </span> <span
                                        class="text-muted small pt-2 ps-1">Kelalaian</span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->


                <!-- Reports -->
                <div class="col-12">
                    <div class="card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Menu</h6>
                                </li>

                                <li><a class="dropdown-item" href="<?= base_url('Absensi/dataabsensiperhari'); ?>">Lihat
                                        Data</a></li>

                            </ul>
                        </div>

                        <div class=" card-body">
                            <h5 class="card-title">Absensi Hari Ini</h5>

                            <!-- Line Chart -->
                            <div id="tampildatadetail"></div>

                            <script>
                            function getdatadetail() {
                                $.ajax({
                                    type: "post",
                                    url: "<?= base_url() ?>/Home/detailabsensi",
                                    data: {
                                        id: 1
                                    },
                                    dataType: "json",
                                    beforeSend: function() {
                                        $('#tampildatadetail').html(
                                            "<div class='spinner-border' role='status'> <span class ='visually-hidden'> Loading... </span> </div> Mohon Tunggu "
                                        );
                                    },
                                    success: function(response) {
                                        if (response.data) {
                                            $('#tampildatadetail').html(response.data);

                                        }

                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        alert(xhr.status + '\n' + thrownError);
                                        alert("Gagal")
                                    }
                                });
                            }
                            </script>
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Reports -->





            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

            <!-- Recent Activity -->
            <div class="card">


                <div class="card-body">
                    <h5 class="card-title">Top 3 Paling Disiplin <span>| Bulan Ini</span></h5>

                    <div class="card-body table-responsive p-0" style="margin-top: 10px;">
                        <!-- Table with hoverable rows -->
                        <table class="table table-hover ">

                            <tbody>

                                <?php
                                $nomor = 1;
                                foreach ($tampildata as $row) :
                                ?>

                                <tr>

                                    <td>#<?= $nomor++ ?></td>


                                    <td>
                                        <img style="max-height: 100px;"
                                            src="<?= base_url() ?>/uploud/<?= $row['foto_karyawan'] ?>" alt="Profile"
                                            class="rounded-circle">
                                    </td>



                                    <td style="min-width: 250px;">
                                        <b><?= $row['nama_karyawan'] ?></b>
                                        <br> <?= $row['jabatan_karyawan'] ?>
                                        <br><b>Hadir : </b><?= $row['Hadir_rekap_informasi'] ?> Hari
                                        <br><b>Absen/Izin : </b><?= $row['Absen_rekap_informasi'] ?> Hari
                                        <br><b>Telat : </b><?= $row['Telat_rekap_informasi'] ?> x
                                        <br><b>Pulang Awal : </b><?= $row['Pulangcepat_rekap_informasi'] ?> x
                                    </td>

                                </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->

                    </div>



                </div>
            </div><!-- End Recent Activity -->




        </div><!-- End Right side columns -->

    </div>

    <script>
    //mangaktifkan tampilan side bar
    $(document).ready(function() {
        $('#beranda').removeClass('collapsed');

        getdatadetail()
        //$('#body').addClass('toggle-sidebar')



    });
    </script>
</section>


<?= $this->endSection('isi') ?>