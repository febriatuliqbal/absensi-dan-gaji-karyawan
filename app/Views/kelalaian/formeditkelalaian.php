<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Edit Data Kelalaian</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Hutang</a></li>
                    <li class="breadcrumb-item active">Edit Data Hutang</li>
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
        <h5 class="card-title">Isi data Kelalaian</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Kelalaian/updatedata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Nama Karyawan</label>


            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input id="iddetail" name="iddetail" value="<?= $id ?>" type="text" class="form-control" hidden>
                <input id="idkelalaian" name="idkelalaian" value="<?= $id_Kelalaian ?>" type="text" class="form-control"
                    hidden>
                <input id="nama" name="nama" value="<?= $namakaryawan ?>" type="text" class="form-control" readonly>
                <input id="username" name="username" value="<?= $idkaryawan ?>" type="text" class="form-control" hidden>
            </div>


            <!-- <div class="col-sm-3">

                <button type="button" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari"
                    style="width: 100%; ">
                    <i class="bi bi-search"> Cari Karyawan</i>
            </div> -->


        </div>

        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Jumlah Kerugian</label>
            <div class="col-sm-10">
                <input id="kerugian" name="kerugian" value="<?= $kerugian ?>" type="number" class="form-control"
                    required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Pot. Kelalaian (50% Kerugian)</label>
            <div class="col-sm-10">
                <input id="potkelalaian" name="potkelalaian" value="<?= $jumlah_kelalain ?>" type="number"
                    class="form-control" readonly>

                <input id="potkelalaianawal" name="potkelalaianawal" value="<?= $jumlah_kelalain ?>" type="number"
                    class="form-control" hidden>
            </div>
        </div>


        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <textarea name="keterangan" class="form-control" style="height: 100px"
                    required><?= $ket_kelalaian ?></textarea>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update</button>
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
    $('#kelalaian').removeClass('collapsed');
    $('#kelalaian-nav').addClass('show');


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

$('#kerugian').keyup(function(e) {
    e.preventDefault();

    let tkerugian = $('#kerugian').val();

    let potongan = 50 * parseFloat(tkerugian) / 100;
    $('#potkelalaian').val(potongan);



});
</script>



<?= $this->endSection('isi') ?>