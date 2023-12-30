<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Laporan Absensi Karyawan</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Absensi Karyawan</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>


<div class="col-lg-12">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Laporan Absensi</h5>

            <?= session()->getFlashdata('error'); ?>
            <?= session()->getFlashdata('sukses'); ?>

            <!-- Default Accordion -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            1-<strong>Laporan Absensi Perhari</strong>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">

                            <h5 class="card-title">Pilih Tanggal</h5>

                            <!-- General Form Elements -->
                            <?= form_open_multipart('Laporan/cetaklaporanabsensiperhari', ['target' => '_blank']) ?>


                            <div class="row mb-3">

                                <div class="col-sm-9">
                                    <input name="tanggal" type="date" value="<?= date('Y-m-d'); ?>" class="form-control"
                                        required>
                                </div>
                                <div class="col-sm-3">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary"> <i
                                            class="bi bi-printer-fill"> </i>
                                        Cetak Laporan</button>
                                </div>
                            </div>

                            <?= form_close() ?>

                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            2-<strong>Laporan Absensi Perbulan Perkaryawan</strong>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5 class="card-title">Pilih Karyawan dan bulan</h5>

                            <!-- General Form Elements -->
                            <?= form_open_multipart('Laporan/cetaklaporankaryawanperbulanperkaryawan', ['target' => '_blank']) ?>


                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Karyawan</label>
                                <div class="col-sm-7" style="margin-bottom: 10px;">
                                    <input id="username" name="username" type="text" class="form-control" hidden>
                                    <input id="nama" name="nama" type="text" class="form-control" readonly>
                                    <input id="jabatan" name="jabatan" type="text" class="form-control" hidden>
                                </div>

                                <div class="col-sm-3">

                                    <button type="button" class="btn btn-m btn-primary" id="tombolcari"
                                        name="tombolcari" style="width: 100%; ">
                                        <i class="bi bi-search"> Cari Karyawan</i>
                                </div>


                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Bulan-Tahun</label>


                                <div class="col-sm-4">
                                    <select style="margin-right: 15px;" name="bulan" class="form-select"
                                        aria-label="Default select example">
                                        <option value="<?= $bulan = date('m') ?>">

                                            <?php if ($bulan == "01") : ?> Januari
                                            <?php elseif ($bulan == "02") : ?> Februari
                                            <?php elseif ($bulan == "03") : ?> Maret
                                            <?php elseif ($bulan == "04") : ?> April
                                            <?php elseif ($bulan == "05") : ?> Mei
                                            <?php elseif ($bulan == "06") : ?> Juni
                                            <?php elseif ($bulan == "07") : ?> Juli
                                            <?php elseif ($bulan == "08") : ?> Agustus
                                            <?php elseif ($bulan == "09") : ?> September
                                            <?php elseif ($bulan == "10") : ?> Oktober
                                            <?php elseif ($bulan == "11") : ?> November
                                            <?php elseif ($bulan == "12") : ?> Desember
                                            <?php endif ?>


                                        </option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">

                                    <select style="margin-right: 15px;" name="tahun" class="form-select"
                                        aria-label="Default select example">
                                        <option value="<?= $tahun = date('Y') ?>"> <?= $tahun ?></option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2032">2032</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                        <option value="2037">2037</option>
                                        <option value="2038">2038</option>
                                        <option value="2039">2039</option>
                                        <option value="2040">2040</option>
                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary"> <i
                                            class="bi bi-printer-fill"> </i>
                                        Cetak Laporan</button>
                                </div>
                            </div>


                        </div>

                        <?= form_close() ?>


                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            3-<strong>Rekap Absen Perbulan</strong>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h5 class="card-title">Pilih bulan</h5>

                            <!-- General Form Elements -->
                            <?= form_open_multipart('Laporan/cetakrekapkaryawanperbulanperkaryawan', ['target' => '_blank']) ?>




                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Bulan-Tahun</label>


                                <div class="col-sm-4">
                                    <select style="margin-right: 15px;" name="bulan2" class="form-select"
                                        aria-label="Default select example">
                                        <option value="<?= $bulan = date('m') ?>">

                                            <?php if ($bulan == "01") : ?> Januari
                                            <?php elseif ($bulan == "02") : ?> Februari
                                            <?php elseif ($bulan == "03") : ?> Maret
                                            <?php elseif ($bulan == "04") : ?> April
                                            <?php elseif ($bulan == "05") : ?> Mei
                                            <?php elseif ($bulan == "06") : ?> Juni
                                            <?php elseif ($bulan == "07") : ?> Juli
                                            <?php elseif ($bulan == "08") : ?> Agustus
                                            <?php elseif ($bulan == "09") : ?> September
                                            <?php elseif ($bulan == "10") : ?> Oktober
                                            <?php elseif ($bulan == "11") : ?> November
                                            <?php elseif ($bulan == "12") : ?> Desember
                                            <?php endif ?>


                                        </option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">

                                    <select style="margin-right: 15px;" name="tahun2" class="form-select"
                                        aria-label="Default select example">
                                        <option value="<?= $tahun = date('Y') ?>"> <?= $tahun ?></option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2032">2032</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                        <option value="2037">2037</option>
                                        <option value="2038">2038</option>
                                        <option value="2039">2039</option>
                                        <option value="2040">2040</option>
                                    </select>

                                </div>

                                <div class="col-sm-3">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary"> <i
                                            class="bi bi-printer-fill"> </i>
                                        Cetak Laporan</button>
                                </div>
                            </div>


                        </div>

                        <?= form_close() ?>

                    </div>
                </div>
            </div>
        </div><!-- End Default Accordion Example -->

    </div>
</div>

<div class="viewmodal" style="display: none;"> </div>


</div>

<script>
//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#laporan').removeClass('collapsed');
    $('#laporan-nav').addClass('show');
    $('#laporanabsensi').addClass('active');

});

$('#tombolcari').click(function(e) {
    e.preventDefault();


    $.ajax({
        url: "<?= base_url() ?>/Karyawan/modaldatakaryawan",

        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modaldatakaryawan').modal('show');
            }
        }

    });

});
</script>



<?= $this->endSection('isi') ?>