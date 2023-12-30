<div class="card-body table-responsive p-0" style="margin-top: -5px;" id="datadetail">
    <!-- Table with hoverable rows -->
    <table class="table table-sm table-hover ">
        <thead>
            <tr>
                <th scope="col">No </th>
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
                                    <?php if (intval($row['Absen_rekap_informasi']) > 3) :
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
                                    <?php if (intval($row['Absen_rekap_informasi']) > 3) :
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

                    <?php if ($row['status_gaji'] == "Accept") : ?>
                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary"
                        title="Cetak Slip Gaji" onclick="cetakslipgaji('<?= $row['id_detail_gaji'] ?>')">
                        <i class="bi bi-printer-fill"> </i>
                    </button>

                    <?php else : ?>
                    <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger"
                        onclick="hapus('<?= $row['id_detail_gaji'] ?>','<?= $row['idgaji'] ?>','<?= $row['total_gaji'] ?>','<?= $row['bonus'] ?>')">
                        <i class="bi bi-trash-fill"></i>
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

function hapus(id, idgaji, totalgaji, bonus) {
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin Menghapus Data ini..?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/Penggajian/hapus",
                data: {
                    id: id,
                    idgaji: idgaji,
                    totalgaji: totalgaji,
                    bonus: bonus
                },
                dataType: "json",
                success: function(response) {

                    if (response.sukses) {

                        let timerInterval
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.sukses,
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
</script>