<div class="card-body table-responsive p-0" style="margin-top: -5px;" id="dataabsensi">
    <!-- Table with hoverable rows -->
    <table class="table table-hover ">

        <tbody>

            <?php
            $nomor = 1;
            foreach ($datadetailabsensi->getResultArray() as $row) :
            ?>

            <tr>

                <td><?= $nomor ?></td>

                <td>


                    <div id="carouselExampleCaptions<?= $nomor ?>" class="carousel slide" data-bs-ride="carousel"
                        style="max-width: 8rem;">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions<?= $nomor ?>"
                                data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions<?= $nomor ?>"
                                data-bs-slide-to="1" aria-label="Slide 2" class=""></button>

                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url() ?>/datagambar/<?= $row['foto_masuk'] ?>" class="d-block w-100"
                                    alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6 style="text-shadow: 3px 3px 5px #000000;">Foto Masuk</h6>

                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url() ?>/datagambar/<?= $row['foto_kaluar'] ?>" class="d-block w-100"
                                    alt="...">
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

                <!-- <td style="width: 10%">

                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary" onclick="edit('<?= $row['id_absensi'] ?>')">
                        <i class="bi bi-pencil-fill"></i>
                    </button>

                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger" onclick="hapus('<?= $row['id_absensi'] ?>')">
                        <i class="bi bi-trash-fill"></i>
                    </button>





                </td> -->
            </tr>

            <?php endforeach; ?>

        </tbody>
    </table>
    <!-- End Table with hoverable rows -->

</div>

<script>

</script>