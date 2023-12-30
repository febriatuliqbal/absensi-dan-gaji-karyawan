<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Lokasi Kantor</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Lokasi Kantor</a></li>

                </ol>
            </nav>
        </div>

    </div>
</div>
</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Isi Koordinat Lokasi</h5>
        <!-- General Form Elements -->
        <?= form_open_multipart('LokasiKantor/updatedata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>
        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Latitude</label>
            <div class="col-sm-10">

                <input name="latitude" type="text" value="<?= $latitude ?>" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Longitude</label>
            <div class="col-sm-10">

                <input name="longitude" type="text" value="<?= $longitude ?>" class="form-control" required>
            </div>
        </div>










        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-8">

                <a href="https://maps.google.com/maps?q=<?= $latitude ?>,<?= $longitude ?>" <i
                    class="bi bi-globe-asia-australia"></i> <b>Lihat Lokasi</b></a>
            </div>
            <div class="col-sm-2">
                <button type="submit" style="width: 100%;" class="btn btn-primary">Simpan Lokasi</button>

            </div>
        </div>



        <?= form_close() ?>

        <!-- <-- End General Form Elements -->

    </div>


    <div class="viewmodal" style="display: none;"> </div>
</div>


<script>
//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#lokasi').removeClass('collapsed');
    $('#lokasi-nav').addClass('show');


});
</script>



<?= $this->endSection('isi') ?>