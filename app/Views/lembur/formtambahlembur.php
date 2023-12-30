<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Input Data Lembur</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Lembur</a></li>
                    <li class="breadcrumb-item active">Input Data Lembur</li>
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
        <h5 class="card-title">Isi data Lembur</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Lembur/simpandata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Nama Karyawan</label>


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
            <label for="inputNumber" class="col-sm-2 col-form-label">Lama Lembur (Jam)</label>
            <div class="col-sm-10">
                <input id="lamalembur" name="lamalembur" type="number" class="form-control" required>
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

$('#kerugian').keyup(function(e) {
    e.preventDefault();

    let tkerugian = $('#kerugian').val();

    let potongan = 50 * parseFloat(tkerugian) / 100;
    $('#potkelalaian').val(potongan);



});



//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#lembur').removeClass('collapsed');
    $('#lembur-nav').addClass('show');
    $('#inputdatalembur').addClass('active');



});
</script>



<?= $this->endSection('isi') ?>