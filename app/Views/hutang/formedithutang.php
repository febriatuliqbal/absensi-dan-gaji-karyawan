<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Edit Data Hutang</b> </h1>
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
        <h5 class="card-title">Isi data Hutang</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Hutang/updatedata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Username</label>

            <input id="id_det_hutang" name="id_det_hutang" value="<?= $id ?>" type="text" class="form-control" hidden>
            <input id="id_hutang" name="id_hutang" value="<?= $id_hutang ?>" type="text" class="form-control" hidden>
            <div class="col-sm-10" style="margin-bottom: 10px;">
                <input id="nama" name="nama" type="text" value="<?= $namakaryawan ?>" class="form-control" readonly>
                <input id="username" name="username" value="<?= $idkaryawan ?>" type="text" class="form-control" hidden>
            </div>


            <div class="col-sm-3" hidden>

                <button type="button" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari"
                    style="width: 100%; ">
                    <i class="bi bi-search"> Cari Karyawan</i>
            </div>


        </div>


        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Jumlah Hutang</label>
            <div class="col-sm-10">
                <input name="hutangawal" type="number" value="<?= $jumlah_hutang ?>" class="form-control" hidden>
                <input name="jumlahhutang" type="number" value="<?= $jumlah_hutang ?>" class="form-control" required>
            </div>
        </div>




        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label">Keterangan</label>
            <div class="col-sm-10">
                <textarea name="keterangan" class="form-control" style="height: 100px"
                    required><?= $ket_hutang ?></textarea>
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
    $('#hutang').removeClass('collapsed');
    $('#hutang-nav').addClass('show');


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