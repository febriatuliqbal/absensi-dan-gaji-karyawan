<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Hutang Perbulan </b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Hutang</a></li>
            <li class="breadcrumb-item active">Daftar Hutang Perbulan</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('hutang/datahutangperbulan') ?>

        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">
            <a href="<?= base_url('Hutang/tambah'); ?>"> <button type="button" class="btn btn-lg btn-primary"
                    style="margin-right: 15px;">


                    <i class="bi bi-plus-square-fill" style="margin-right: 5px;"></i> <b> Input
                        Data
                    </b>
                </button></a>

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
                            <span class="badge bg-primary"> Rp.
                                <?= number_format($rew['subtotal_hutang'], 0) ?></span>


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
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nama Karyawan</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Ket</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                        $nomor = 1 + (($nohalaman - 1) * 10);

                                        $totalhutang = 0;
                                        foreach ($tampildatadetail as $row) :
                                            $totalhutang = $totalhutang + $row['jumlah_hutang']
                                        ?>

                                    <tr>

                                        <?php if ($row['nama_karyawan'] == $rew['nama_karyawan']) : ?>
                                        <td><?= $nomor++ ?></td>




                                        <td>

                                            <?= date('d', strtotime($row['tgl_hutang'])) . " " . date('F', strtotime($row['tgl_hutang'])) . " " . date('Y', strtotime($row['tgl_hutang'])) ?>

                                        </td>
                                        <td>
                                            <?= $row['nama_karyawan'] ?>
                                        </td>
                                        <td>
                                            Rp. <?= number_format($row['jumlah_hutang'], 0) ?>
                                        </td>


                                        <td>
                                            <?= $row['ket_hutang'] ?>
                                        </td>



                                        <td style="width: 10%">

                                            <button style="margin-bottom: 3px;" type="button"
                                                class="btn  btn-sm btn-primary"
                                                onclick="edit('<?= $row['id_detail_hutang'] ?>')">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>

                                            <button style="margin-bottom: 3px;" type="button"
                                                class="btn  btn-sm btn-danger"
                                                onclick="hapus('<?= $row['id_detail_hutang'] ?>','<?= $row['jumlah_hutang'] ?>','<?= $row['id_hutang'] ?>')">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>


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
    window.location.href = ('<?= base_url() ?>/Hutang/edit/') + id;


}

function hapus(id, jumlah, idhutang) {
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
                url: "<?= base_url() ?>/Hutang/hapus",
                data: {
                    id: id,
                    jumlah: jumlah,
                    idhutang: idhutang

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
    $('#hutang').removeClass('collapsed');
    $('#hutang-nav').addClass('show');
    $('#datahutangperbulan').addClass('active');

});
</script>



<?= $this->endSection('isi') ?>