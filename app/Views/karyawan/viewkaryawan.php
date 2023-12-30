<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Karyawan</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Karyawan</a></li>
            <li class="breadcrumb-item active">Daftar Karyawan</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('karyawan/index') ?>

        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">
            <a href="<?= base_url('Karyawan/tambah'); ?>"> <button type="button" class="btn btn-lg btn-primary"
                    style="margin-right: 15px;">


                    <i class="bi bi-plus-square-fill" style="margin-right: 5px;"></i> <b> Tambah
                        Data
                    </b>
                </button></a>


            <input type="text" class="form-control form-control-m" placeholder="Cari Data Karyawan" name="cari"
                value="<?= $cari; ?>">

            <button type="submit" class="btn btn-m btn-orange" id="tombolcari" name="tombolcari">
                <i class="bi bi-search"></i>
            </button>





        </div>
        <?= form_close() ?>
        <div class="card-body table-responsive p-0" style="margin-top: 10px;">
            <!-- Table with hoverable rows -->
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Gaji Pokok</th>
                        <th scope="col">Tunj. Makan</th>
                        <th scope="col">Tunj. Kehadiran</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Usename</th>
                        <th scope="col">Aksi</th>


                    </tr>
                </thead>
                <tbody>

                    <?php
                    $nomor = 1 + (($nohalaman - 1) * 10);
                    foreach ($tampildata as $row) :
                    ?>

                    <tr>

                        <td><?= $nomor++ ?></td>

                        <td>
                            <img style="max-height: 50px;" src="<?= base_url() ?>/uploud/<?= $row['foto_karyawan'] ?>"
                                alt="Profile" class="rounded-circle">
                        </td>


                        <td>
                            <?= $row['nama_karyawan'] ?>
                        </td>
                        <td>
                            <?= $row['jabatan_karyawan'] ?>
                        </td>
                        <td>
                            <?= $row['status_karyawan'] ?>
                        </td>
                        <td>
                            Rp. <?= number_format($row['gajipokok__karyawan'], 0) ?>
                        </td>

                        <td>
                            Rp. <?= number_format($row['tmakan_karyawan'], 0) ?>
                        </td>

                        <td>
                            Rp. <?= number_format($row['thadir_karyawan'], 0) ?>
                        </td>

                        <td>
                            <?= $row['alamat_karyawan'] ?>
                        </td>

                        <td>
                            <?= $row['username_karyawan'] ?>
                        </td>

                        <td style="width: 10%">

                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                                onclick="edit('<?= $row['idkaryawan'] ?>')">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger"
                                onclick="hapus('<?= $row['idkaryawan'] ?>')">
                                <i class="bi bi-trash-fill"></i>
                            </button>





                        </td>
                    </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
            <!-- End Table with hoverable rows -->

        </div>

        <br>

        <div class="float-center">
            <?= $pager->links('nomor', 'paging'); ?>
        </div>
    </div>
</div>


<script>
function edit(id) {
    window.location.href = ('<?= base_url() ?>/Karyawan/edit/') + id;


}

function hapus(id) {
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin Menghapus Transaksi ini..?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/Karyawan/hapus",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {

                    if (response.sukses) {

                        let timerInterval
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'ITEM BERHASIL DIHAPUS',
                            html: 'Otomatis Tertutup Dalam <b></b> milliseconds.',
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            /* Read more about handling dismissals below */

                            window.location.reload();
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer')

                            }
                        })

                    }


                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });




        }
    });
}
//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#karyawan').removeClass('collapsed');
    $('#components-nav').addClass('show');
    $('#daftrakaryawan').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>