<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Seluruh Data Lembur</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Lembur</a></li>
            <li class="breadcrumb-item active">Data Lembur</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('Lembur/index') ?>

        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">
            <a href="<?= base_url('Lembur/tambah'); ?>"> <button type="button" class="btn btn-lg btn-primary"
                    style="margin-right: 15px;">


                    <i class="bi bi-plus-square-fill" style="margin-right: 5px;"></i> <b> Input
                        Data
                    </b>
                </button></a>





            <input type="text" class="form-control form-control-m" placeholder="Cari Berdasarkan Nama Karyawan"
                name="cari" value="<?= $cari; ?>">

            <button type="submit" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari">
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
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Lama Lembur (jam)</th>
                        <th scope="col">Ket</th>
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

                            <?= date('d', strtotime($row['tgllembur'])) . " " . date('F', strtotime($row['tgllembur'])) . " " . date('Y', strtotime($row['tgllembur'])) ?>

                        </td>
                        <td>
                            <?= $row['nama_karyawan'] ?>
                        </td>

                        <td>
                            <?= $row['lama_lembur'] ?> Jam


                        </td>

                        <td>
                            <?= $row['ket'] ?>

                        </td>




                        <td style="width: 10%">

                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                                onclick="edit('<?= $row['id_detail'] ?>')">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger"
                                onclick="hapus('<?= $row['id_detail'] ?>','<?= $row['lama_lembur'] ?>','<?= $row['id_lembur'] ?>')">
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
    window.location.href = ('<?= base_url() ?>/Lembur/edit/') + id;


}

function hapus(id, jumlah, idkelalaian) {
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
                url: "<?= base_url() ?>/Lembur/hapus",
                data: {
                    id: id,
                    jumlah: jumlah,
                    idkelalaian: idkelalaian
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
    $('#lembur').removeClass('collapsed');
    $('#lembur-nav').addClass('show');
    $('#datalembur').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>