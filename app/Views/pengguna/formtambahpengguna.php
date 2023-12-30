<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Input Data Pengguna</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Pengguna</a></li>
                    <li class="breadcrumb-item active">Input Data Pengguna</li>
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
        <h5 class="card-title">Isi data Pengguna</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('User/simpandata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">UserName</label>
            <div class="col-sm-10">
                <input name="username" type="text" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input name="password" type="password" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select name="level" class="form-select" aria-label="Default select example" required>
                    <option value="">Tekan Untuk Memilih</option>
                    <option value="1">1 - Admin</option>
                    <option value="2">2 - Pimpinan</option>
                    <option value="3">3 - Karyawan</option>

                </select>
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
</div>




<script>
//mangaktifkan tampilan side bar




$(document).ready(function() {
    $('#Pengguna').removeClass('collapsed');
    $('#Pengguna-nav').addClass('show');
    $('#tambahpengguna').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>