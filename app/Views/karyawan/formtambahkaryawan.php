<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Input Data Karyawan</b> </h1>
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
        <h5 class="card-title">Isi data karyawan</h5>

        <!-- General Form Elements -->
        <?= form_open_multipart('Karyawan/simpandata') ?>
        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input name="nama" type="text" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Jabatan</label>
            <div class="col-sm-10">
                <input name="jabatan" type="text" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
                <select name="status" class="form-select" aria-label="Default select example" required>
                    <option value="">Tekan Untuk Memilih</option>
                    <option value="Training">Training</option>
                    <option value="Junior">Junior</option>
                    <option value="Midle">Midle</option>
                    <option value="Senior">Senior</option>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Gaji Pokok</label>
            <div class="col-sm-10">
                <input name="gapok" type="number" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Tunjangan Makan</label>
            <div class="col-sm-10">
                <input name="tmakan" type="number" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Tunjangan Hadir</label>
            <div class="col-sm-10">
                <input name="thadir" type="number" class="form-control" required>
            </div>
        </div>


        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <textarea name="alamat" class="form-control" style="height: 100px" required></textarea>
            </div>
        </div>



        <div class="row mb-3">
            <label for="inputNumber" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input name="gambar" class="form-control" type="file" id="formFile" required>
            </div>
        </div>

        <div class="row mb-3">
            <label for="inputText" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-7" style="margin-bottom: 10px;">
                <input id="username" name="username" type="text" class="form-control" readonly>
            </div>

            <div class="col-sm-3">

                <button type="button" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari" style="width: 100%; ">
                    <i class="bi bi-search"> Cari Username</i>
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
            url: "<?= base_url() ?>/user/modalDataPelanggan",

            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldatapengguna').modal('show');
                }
            }

        });

    });



    //mangaktifkan tampilan side bar
    $(document).ready(function() {
        $('#karyawan').removeClass('collapsed');
        $('#components-nav').addClass('show');
        $('#tambahkaryawan').addClass('active');



    });
</script>



<?= $this->endSection('isi') ?>