<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MA. Advertising|Laporan Data Hutang Karyawan Perbulan</title>

    <link href="<?= base_url() ?>/assets/img/logomabaru.png" rel="icon">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css?v=3.2.0">

</head>

<body style="margin: 1rem;">
    <div class=" wrapper">
        <section class="invoice">

            <div class="row">
                <div class="col-12" style="background-color: #efefef;">
                    <h2 class="page-header">
                        <img style="max-height: 3rem;" src="<?= base_url() ?>/assets/img/logomaadv.png"
                            alt="Logo Perusahaan">
                        <small class="float-right" style="font-size:0.8rem ;">

                            Jl. DR. Wahidin no. 17 (Samping KORAMIL 02 Padang Timur)
                            Ganting Parak Gadang Kota Padang
                            <br> Email: mas.anif.maju@gmail.com
                            <br> HP/WA : 0813 6310 9625 / 0822 1869 1311



                        </small>
                    </h2>
                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-sm-2 ">

                </div>

                <div class="col-sm-8">
                    <center> <b>
                            <address>
                                <h3><b>Laporan Data Hutang Karyawan <br> Perbulan Perkaryawan</b></h3>


                            </address>
                        </b></center>


                </div>

                <div class="col-sm-2 ">


                </div>



            </div>

            <div class="row invoice-info">


                <div class="col-sm-3 invoice-col" style="margin-left: 20px;">

                    <address>
                        Nama : <b><?= $nama ?></b>

                        <br>Jabatan : <b> <?= $jabatan ?></b>
                        <br> Periode : <b> <?php if ($bulan == "01") : ?>
                            Januari
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
                            <?= $tahun ?>
                        </b>



                    </address>
                </div>






            </div>


            <div class="row" style="margin: 10px;">
                <div class="col-12 table-responsive">
                    <table class="table table-striped  table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>

                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah Hutang</th>
                                <th scope="col">Keterangan</th>



                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $nomor = 1;
                            foreach ($datadetaillaporan->getResultArray() as $row) :
                            ?>
                            <tr>
                                <td style="width: 2%;"><?= $nomor++ ?></td>



                                <td>
                                    <?= $row['tgl_hutang'] ?>
                                </td>

                                <td>

                                    Rp. <?= number_format($row['jumlah_hutang'], 0) ?>
                                </td>
                                <td>
                                    <?= $row['ket_hutang'] ?>
                                </td>


                            </tr>

                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2"><b>Total Hutang</b></td>
                                <td colspan="2">
                                    <h5><b>Rp. <?= number_format($totalSubtotal, 0) ?></h5></b>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>





            </div>




            <br><br>
            <div class="row ">

                <div class="col-9">
                </div>
                <div class="col-3 float-right">
                    <h6 class="float-right">Padang, <?= date("d-F-Y") ?>
                        <br><?php if (session()->idlevel == 1) : ?>
                        Admin
                        <?php elseif (session()->idlevel == 2) : ?>
                        Pimpinan
                        <?php endif ?> <br><br>
                        (<?= session()->namauser ?>)

                    </h6>
                </div>




            </div>
            <br>









        </section>

    </div>


    <script data-cfasync=" false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
    </script>
    <script>
    window.addEventListener("load", window.print());
    </script>
</body>

</html>