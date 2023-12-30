<div class="card-body table-responsive p-0" style="margin-top: -5px;" id="datadetail">
    <!-- Table with hoverable rows -->
    <table class="table table-sm table-hover ">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama (Jabatan) </th>

                <th scope="col">Penghasilan</th>
                <th scope="col">Potongan</th>
                <th scope="col">Bonus</th>
                <th scope="col">Total Gaji</th>
                <th scope="col">Hutang</th>
                <th scope="col">Gaji Diterima</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>


            </tr>
        </thead>
        <tbody>

            <?php
            $nomor = 1;
            foreach ($datadetailgaji->getResultArray()  as $row) :
            ?>

            <tr>

                <td><?= $nomor ?></td>


                <td>
                    <b><?= $row['nama_karyawan'] ?></b> (<?= $row['jabatan_karyawan'] ?>)
                </td>



                <td>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne<?= $nomor ?>" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    Rp.
                                    <?= number_format($row['gajipokoksaatini'] + $row['tunj_makansaatini'] + $row['tunj_hadirsaatini'] + $row['Lembur_informasi'] * 10000, 0) ?>
                                </button>
                            </h2>
                            <div id="collapseOne<?= $nomor ?>" class="accordion-collapse collapse"
                                aria-labelled="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Gaji Pokok:
                                    <br> <b>Rp. <?= number_format($row['gajipokoksaatini'], 0) ?></b>
                                    <br> T Makan:
                                    <br> <b> Rp. <?= number_format($row['tunj_makansaatini'], 0) ?></b>
                                    <br> T. Hadir:
                                    <br> <b>Rp. <?= number_format($row['tunj_hadirsaatini'], 0) ?></b>
                                    <br> Lembur:
                                    <br> <b> Rp.
                                        <?= number_format($row['Lembur_informasi'] * 10000, 0) ?></b>

                                </div>
                            </div>

                        </div>
                    </div>

                </td>

                <td>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne2<?= $nomor ?>" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    <?php if (intval($row['Absen_rekap_informasi']) > 1) :
                                            $potongankehadiran = (intval($row['Absen_rekap_informasi']) - 3) * 50000
                                        ?> Rp.
                                    <?= number_format($potongankehadiran + $row['Telat_rekap_informasi'] * 20000 + $row['Pulangcepat_rekap_informasi'] * 20000 + $row['Potongan_informasi'], 0) ?></b>
                                    <?php else : ?> Rp.
                                    <?= number_format($row['Telat_rekap_informasi'] * 20000 + $row['Pulangcepat_rekap_informasi'] * 20000 + $row['Potongan_informasi'], 0) ?></b>
                                    <?php endif ?>
                                </button>
                            </h2>
                            <div id="collapseOne2<?= $nomor++ ?>" class="accordion-collapse collapse"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <?php if (intval($row['Absen_rekap_informasi']) > 1) :
                                            $potongankehadiran = (intval($row['Absen_rekap_informasi']) - 3) * 50000
                                        ?> P Hadir:
                                    <br> <b> Rp. <?= number_format($potongankehadiran, 0) ?></b>
                                    <?php else : ?>
                                    P Hadir:
                                    <br><b>Rp.0</b>
                                    <?php endif ?>
                                    <br>P Telat:
                                    <br><b>Rp. <?= number_format($row['Telat_rekap_informasi'] * 20000, 0) ?></b>
                                    <br>P Pulang Cepat:
                                    <br><b>Rp. <?= number_format($row['Pulangcepat_rekap_informasi'] * 20000, 0) ?></b>
                                    <br>P Kelalaian:
                                    <br><b>Rp. <?= number_format($row['Potongan_informasi'], 0) ?></b>

                                </div>
                            </div>

                        </div>
                    </div>

                </td>

                <td>
                    Rp.
                    <?= number_format($row['bonus'], 0) ?>
                </td>

                <td>
                    <b>Rp. <?= number_format($row['total_gaji'], 0) ?></b>
                </td>
                <td>
                    Rp.
                    <?= number_format($row['Hutang_informasi'], 0) ?>
                </td>

                <td>
                    <b> Rp.
                        <?= number_format($row['gajiditerima'], 0) ?></b>
                </td>
                <td>



                    <?php if ($row['status_gaji'] == "Accept") : ?>

                    <span class="badge bg-success">
                        <?= $row['status_gaji'] ?>
                    </span>
                    <?php else : ?>


                    <span class="badge bg-danger">
                        <?= $row['status_gaji'] ?>
                    </span>


                    <?php endif ?>
                </td>



                <td>

                    <?php if ($row['status_gaji'] == "Pending") : ?>


                    <button style=" margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                        onclick="pilih('<?= $row['id_detail_gaji'] ?>','<?= $row['nama_karyawan'] ?>','<?= $row['bonus'] ?>')">
                        <i class="bi bi-cursor-fill"></i>Pilih
                    </button>


                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-success"
                        onclick="accept('<?= $row['id_detail_gaji'] ?>')">
                        <i class="bi bi-check-circle"> </i>Accept
                    </button>

                    <?php else : ?>
                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                        title="Cetak Slip Gaji" onclick="cetakslipgaji('<?= $row['id_detail_gaji'] ?>')">
                        <i class="bi bi-printer-fill"> </i>
                    </button>

                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger"
                        onclick="pending('<?= $row['id_detail_gaji'] ?>')">
                        <i class="bi bi-check-circle"> </i>Pending
                    </button>


                    <?php endif ?>





                </td>

            </tr>


            <?php endforeach; ?>

        </tbody>
    </table>
    <!-- End Table with hoverable rows -->

</div>

<script>
function cetakslipgaji(id) {
    // window.location.href = ('<?= base_url() ?>/Laporan/cetakslipgaji/') + id;

    let windowCetak = window.open('<?= base_url() ?>/Laporan/cetakslipgaji/' + id, "CETAK FAKTUR BARANG KELUAR",
        "width=600px,height=600px");
    windowCetak.focus();


}

function pilih(id, nama, bonus) {

    // kalau pakai javasrip ambilnya menggunakan id

    $('#iddetail').val(id);
    $('#nama').val(nama);
    $('#bonus').val(bonus);
    $('#bonuslama').val(bonus);
    $('#bonus').focus();



}

function accept(id) {

    // kalau pakai javasrip ambilnya menggunakan id

    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/Penggajian/acceptgaji",
        data: {
            id: id,


        },
        dataType: "json",
        success: function(response) {
            if (response.success) {

                getdatadetail()

                Swal.fire({
                    icon: 'success',
                    title: 'Oppss....',
                    text: response.success,

                })

                kosong();

            }
            if (response.gagal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oppss....',
                    text: response.gagal,

                })
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {

            Swal.fire({
                icon: 'error',
                title: 'Oppss....',
                text: 'Json Tidak ditemukan',

            })
        }
    });




}

function pending(id) {

    // kalau pakai javasrip ambilnya menggunakan id

    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/Penggajian/pendinggaji",
        data: {
            id: id,


        },
        dataType: "json",
        success: function(response) {
            if (response.success) {

                getdatadetail()

                Swal.fire({
                    icon: 'success',
                    title: 'Oppss....',
                    text: response.success,

                })

                kosong();

            }
            if (response.gagal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oppss....',
                    text: response.gagal,

                })
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {

            Swal.fire({
                icon: 'error',
                title: 'Oppss....',
                text: 'Json Tidak ditemukan',

            })
        }
    });




}
</script>