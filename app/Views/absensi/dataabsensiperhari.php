<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Absensi Perhari </b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Kelalaian</a></li>
            <li class="breadcrumb-item active">Daftar Absensi Perhari</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">



        <div class="input-group" style="margin-top: 15px; display: flex;">

            <input type="date" class="form-control form-control-m" placeholder="Cari Data Karyawan" name="tanggal"
                id="tanggal" value="<?= date('Y-m-d'); ?>">

        </div>
        <br>

        <div id="tampildatadetail"></div>

        <script>
        function getdatadetail() {
            let tanggal = $('#tanggal').val();
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/Absensi/detailabsensi",
                data: {
                    tanggal: tanggal
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tampildatadetail').html(
                        "<i class='fa fa-spin fa-spinner'></i> &nbsp&nbsp  Mohon Tunggu"
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

        $('#tanggal').change(function(e) {

            getdatadetail()
        });
        </script>

        <br>





        <br>


    </div>
</div>


<script>
//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#absensi').removeClass('collapsed');
    $('#absensi-nav').addClass('show');
    $('#dataabsensiperhari').addClass('active');
    getdatadetail()

});
</script>



<?= $this->endSection('isi') ?>