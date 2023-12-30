<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Absensi</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Absensi</a></li>
            <li class="breadcrumb-item active">Daftar Absensi</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('Absensi/index') ?>


        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">

            <input type="text" class="form-control form-control-m" placeholder="Cari Data Karyawan" name="cari"
                value="<?= $cari; ?>">

            <button type="submit" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari">
                <i class="bi bi-search"></i>
            </button>





        </div>
        <?= form_close() ?>
        <div class="card-body table-responsive p-0" style="margin-top: 10px;">
            <!-- Table with hoverable rows -->
            <table class="table table-hover ">

                <tbody>

                    <?php
                    $nomor = 1 + (($nohalaman - 1) * 10);
                    foreach ($tampildata as $row) :
                    ?>

                    <tr>

                        <td><?= $nomor ?></td>

                        <td>


                            <div id="carouselExampleCaptions<?= $nomor ?>" class="carousel slide"
                                data-bs-ride="carousel" style="max-width: 8rem;">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions<?= $nomor ?>"
                                        data-bs-slide-to="0" class="active" aria-label="Slide 1"
                                        aria-current="true"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions<?= $nomor ?>"
                                        data-bs-slide-to="1" aria-label="Slide 2" class=""></button>

                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="<?= base_url() ?>/datagambar/<?= $row['foto_masuk'] ?>"
                                            class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h6 style="text-shadow: 3px 3px 5px #000000;">Foto Masuk</h6>

                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="<?= base_url() ?>/datagambar/<?= $row['foto_kaluar'] ?>"
                                            class="d-block w-100" alt="...">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h6 style="text-shadow: 3px 3px 5px #000000;">Foto Keluar</h6>

                                        </div>
                                    </div>

                                </div>

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleCaptions<?= $nomor ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleCaptions<?= $nomor++ ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                            </div>
                        </td>



                        <td style="min-width: 250px;">
                            <b>Id Absensi :</b>
                            <?= $row['id_absensi'] ?>
                            <br><b>Nama :</b>
                            <?= $row['nama_karyawan'] ?>
                            <br><b>Tanggal :</b>
                            <?= $row['tgl_absensi'] ?>
                            <br><b>Shift : </b><?= $row['nama_jamkerja'] ?>
                            <br><b>Masuk : </b><?= $row['jam_masuk'] ?>
                            <br><b>Keluar : </b><?= $row['jam_pulang'] ?>
                        </td>

                        <td>
                            <b>Lokasi :</b> <br> <a
                                href="https://maps.google.com/maps?q=<?= $row['lokasi_masuk'] ?>"><?= $row['lokasi_masuk'] ?></a>
                            <br> <b>Keterangan :</b>
                            <br> <?= $row['keterangan'] ?>

                            <br>


                            <?php if ($row['status'] == "Tepat Waktu") : ?>

                            <span class="badge bg-success">
                                <?= $row['status'] ?>
                            </span>

                            <?php elseif ($row['status'] == "Terlambat") : ?>

                            <span class="badge bg-warning"> <?= $row['status'] ?></span>

                            <?php elseif ($row['status'] == "Pulang Cepat") : ?>

                            <span class="badge bg-warning"> <?= $row['status'] ?></span>

                            <?php elseif ($row['status'] == "Libur") : ?>

                            <span class="badge bg-primary"><?= $row['status'] ?></span>

                            <?php else : ?>


                            <span class="badge bg-danger">
                                <?= $row['status'] ?>
                            </span>


                            <?php endif ?>
                        </td>

                        <td style="width: 10%">



                            <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger"
                                onclick="hapus('<?= $row['id_absensi'] ?>','<?= $row['id_karyawan'] ?>','<?= $row['tgl_absensi'] ?>')">
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
    window.location.href = ('<?= base_url() ?>/User/edit/') + id;


}

function hapus(id, username, tgl) {
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin Menghapus Pengguna ini..?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/Absensi/hapus",
                data: {
                    id: id,
                    username: username,
                    tgl: tgl,
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
    $('#absensi').removeClass('collapsed');
    $('#absensi-nav').addClass('show');
    $('#daftarabsensi').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>