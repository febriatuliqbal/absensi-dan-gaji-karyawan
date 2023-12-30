<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Absensi Perbulan </b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Absensi</a></li>
            <li class="breadcrumb-item active">Daftar Absensi Perbulan</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('Absensi/dataperbulan') ?>

        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">




            <select style="margin-right: 15px;" name="bulan" class="form-select" aria-label="Default select example">
                <option value="<?= $bulan ?>">

                    <?php if ($bulan == "01") : ?> Januari
                    <?php elseif ($bulan == "02") : ?> Februari
                    <?php elseif ($bulan == "03") : ?> Maret
                    <?php elseif ($bulan == "04") : ?> April
                    <?php elseif ($bulan == "05") : ?> Mei
                    <?php elseif ($bulan == "06") : ?> Juni
                    <?php elseif ($bulan == "07") : ?> Juli
                    <?php elseif ($bulan == "08") : ?> Agustus
                    <?php elseif ($bulan == "09") : ?> September
                    <?php elseif ($bulan == "10") : ?> Oktober
                    <?php elseif ($bulan == "11") : ?> November
                    <?php elseif ($bulan == "12") : ?> Desember
                    <?php endif ?>


                </option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>

            <select style="margin-right: 15px;" name="tahun" class="form-select" aria-label="Default select example">
                <option value="<?= $tahun ?>"> <?= $tahun ?></option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2032">2032</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>
            </select>

            <button type="submit" class="btn btn-m btn-primary" id="tombolcari" name="tombolcari">
                <i class="bi bi-search"></i>
            </button>





        </div>
        <br>

        <?php
        $urutan = 1 + (($nohalaman - 1) * 10);

        $totalhutang = 0;
        foreach ($tampildata as $rew) :

        ?>

        <!-- Default Accordion -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne<?= $urutan ?>" aria-expanded="false" aria-controls="collapseOne">
                        <b>
                            <?= $urutan ?>
                            <?= "-" ?>
                            <?= $rew['nama_karyawan'] ?>
                            <?= "-" ?>
                            <span class="badge bg-primary"> Hadir :<?= $rew['Hadir_rekap_informasi'] ?></span>
                            <span class="badge bg-danger"> Absen :<?= $rew['Absen_rekap_informasi'] ?></span>
                            <span class="badge bg-warning" style="color: black;"> Telat
                                :<?= $rew['Telat_rekap_informasi'] ?></span>
                            <span class="badge bg-warning" style="color: black;"> Pulang Awal
                                :<?= $rew['Pulangcepat_rekap_informasi'] ?></span>



                        </b>
                    </button>
                </h2>
                <div id="collapseOne<?= $urutan++ ?>" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <?= form_close() ?>
                        <div class="card-body table-responsive p-0" style="margin-top: 10px;">
                            <!-- Table with hoverable rows -->
                            <table class="table table-hover ">

                                <tbody>

                                    <?php
                                        $nomor = 1 + (($nohalaman - 1) * 10);

                                        $totalhutang = 0;
                                        foreach ($tampildatadetail as $row) :

                                        ?>

                                    <tr>

                                        <?php if ($row['nama_karyawan'] == $rew['nama_karyawan']) : ?>
                                        <td><?= $nomor ?></td>

                                        <td>
                                            <div id="carouselExampleCaptions<?= $nomor ?><?= $urutan ?>"
                                                class="carousel slide" data-bs-ride="carousel" style="max-width: 8rem;">
                                                <div class="carousel-indicators">
                                                    <button type="button"
                                                        data-bs-target="#carouselExampleCaptions<?= $nomor ?><?= $urutan ?>"
                                                        data-bs-slide-to="0" class="active" aria-label="Slide 1"
                                                        aria-current="true"></button>
                                                    <button type="button"
                                                        data-bs-target="#carouselExampleCaptions<?= $nomor ?><?= $urutan ?>"
                                                        data-bs-slide-to="1" aria-label="Slide 2" class=""></button>

                                                </div>
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <img src="<?= base_url() ?>/datagambar/<?= $row['foto_masuk'] ?>"
                                                            class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h6 style="text-shadow: 3px 3px 5px #000000;">Foto Masuk
                                                            </h6>

                                                        </div>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <img src="<?= base_url() ?>/datagambar/<?= $row['foto_kaluar'] ?>"
                                                            class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h6 style="text-shadow: 3px 3px 5px #000000;">Foto Keluar
                                                            </h6>

                                                        </div>
                                                    </div>

                                                </div>

                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselExampleCaptions<?= $nomor ?><?= $urutan ?>"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselExampleCaptions<?= $nomor++ ?><?= $urutan ?>"
                                                    data-bs-slide="next">
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


                                        <?php else : ?>

                                        <?php endif; ?>



                                    </tr>

                                    <?php endforeach; ?>







                                </tbody>
                            </table>
                            <!-- End Table with hoverable rows -->

                        </div>
                    </div>
                </div>
            </div>


        </div><!-- End Default Accordion Example -->

        <?php endforeach; ?>



        <br>

        <div class="float-center">
            <?= $pager->links('nomor', 'paging'); ?>
        </div>
    </div>
</div>


<script>
function edit(id) {
    window.location.href = ('<?= base_url() ?>/Kelalaian/edit/') + id;


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
                url: "<?= base_url() ?>/Kelalaian/hapus",
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
    $('#absensi').removeClass('collapsed');
    $('#absensi-nav').addClass('show');
    $('#dataabsensiperbulan').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>