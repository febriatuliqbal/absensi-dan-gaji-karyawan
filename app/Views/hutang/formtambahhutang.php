<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Input Data Hutang</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Karyawan</a></li>
                    <li class="breadcrumb-item active">Input Data Karyawan</li>
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
        <h5 class="card-title">Isi data Hutang</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Hutang/simpandata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Username</label>


            <div class="col-sm-7" style="margin-bottom: 10px;">
                <input id="nama" name="nama" type="text" class="form-control" readonly>
                <input id="username" name="username" type="text" class="form-control" hidden>
            </div>


            <div class="col-sm-3">

                <button type="button" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari"
                    style="width: 100%; ">
                    <i class="bi bi-search"> Cari Karyawan</i>
            </div>


        </div>


        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Jumlah Hutang</label>
            <div class="col-sm-10">
                <input name="jumlahhutang" type="number" class="form-control" required>
            </div>
        </div>




        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <textarea name="keterangan" class="form-control" style="height: 100px" required></textarea>
            </div>
        </div>








        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>



        <?= form_close() ?>

        <!-- <-- End General Form Elements -->

    </div>

    <div class="viewmodal" style="display: none;"> </div>


</div>


<script>
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



//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#hutang').removeClass('collapsed');
    $('#hutang-nav').addClass('show');
    $('#inputdatahutang').addClass('active');



});
</script>



<?= $this->endSection('isi') ?>