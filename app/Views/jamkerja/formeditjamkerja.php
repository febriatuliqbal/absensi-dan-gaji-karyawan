<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Edit Jam Kerja</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Jam Kerja</a></li>
                    <li class="breadcrumb-item active">Edit Jam Kerja</li>
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
        <h5 class="card-title">Isi data karyawan</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Jamkerja/updatedata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-0">
            <div class="col-sm-10">
                <input value="<?= $id ?>" name="id" type="text" class="form-control" required hidden>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input value="<?= $nama_jamkerja ?>" name="nama" type="text" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Jam Masuk</label>
            <div class="col-sm-10">
                <input value="<?= $jammasuk ?>" name="jammasuk" type="time" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Jam Keluar</label>
            <div class="col-sm-10">
                <input value="<?= $jamkeluar ?>" name="jamkeluar" type="time" class="form-control" required>
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


</div>


<script>
//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#karyawan').removeClass('collapsed');
    $('#components-nav').addClass('show');


});
</script>



<?= $this->endSection('isi') ?>