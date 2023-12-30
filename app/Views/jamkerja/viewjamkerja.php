<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Jam Kerja</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Jam Kerja</a></li>
            <li class="breadcrumb-item active">Daftar Jam Kerja</li>
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


        <div class="card-body table-responsive p-0" style="margin-top: 10px;">
            <!-- Table with hoverable rows -->
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Keluar</th>
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
                            <?= $row['nama_jamkerja'] ?>
                        </td>
                        <td>
                            <?= $row['jammasuk'] ?>
                        </td>
                        <td>
                            <?= $row['jamkeluar'] ?>
                        </td>


                        <td style="width: 10%">

                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                                onclick="edit('<?= $row['id'] ?>')">
                                <i class="bi bi-pencil-fill"></i>
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
    window.location.href = ('<?= base_url() ?>/Jamkerja/edit/') + id;


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
                url: "<?= base_url() ?>/Jamkerja/hapus",
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
    $('#Jamkerja').removeClass('collapsed');

});
</script>



<?= $this->endSection('isi') ?>