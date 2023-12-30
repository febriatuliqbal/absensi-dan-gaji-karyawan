<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">


    <h1> <b>Daftar Pengguna</b> </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Pengguna</a></li>
            <li class="breadcrumb-item active">Daftar Pengguna</li>
        </ol>
    </nav>



</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">



    <div class="card-body">

        <?= form_open('User/index') ?>


        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="input-group" style="margin-top: 15px; display: flex;">
            <a href="<?= base_url('User/tambah'); ?>"> <button type="button" class="btn btn-lg btn-primary" style="margin-right: 15px;">


                    <i class="bi bi-plus-square-fill" style="margin-right: 5px;"></i> <b> Tambah
                        Data
                    </b>
                </button></a>


            <input type="text" class="form-control form-control-m" placeholder="Cari Data Pengguna" name="cari" value="<?= $cari; ?>">

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
                        <th scope="col">Usename</th>
                        <th scope="col">Level</th>
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
                                <?= $row['username_peng'] ?>
                            </td>
                            <td>

                                <?php if ($row['peng_level'] == 1) : ?>

                                    <span class="badge bg-success"> 1-Admin</span>

                                <?php elseif ($row['peng_level'] == 2) : ?>

                                    <span class="badge bg-danger"> 2-Pimpinan</span>

                                <?php else : ?>

                                    <span class="badge bg-primary"> 3-Karyawan</span>


                                <?php endif ?>




                            </td>

                            <td style="width: 10%">

                                <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-primary" onclick="edit('<?= $row['username_peng'] ?>')">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                <button style="margin-bottom: 3px;" type="button" class="btn  btn-sm btn-danger" onclick="hapus('<?= $row['username_peng'] ?>')">
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

    function hapus(id) {
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
                    url: "<?= base_url() ?>/User/hapus",
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
        $('#pengguna').removeClass('collapsed');
        $('#Pengguna-nav').addClass('show');
        $('#daftrapengguna').addClass('active');

    });
</script>



<?= $this->endSection('isi') ?>