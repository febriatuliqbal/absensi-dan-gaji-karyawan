<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MA. Advertising|Laporan Data Lembur Karyawan Perbulan</title>

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
                <div class="col-12">
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
                                <h3><b>Laporan Data Lembur Karyawan <br> Perbulan </b>
                                    <small><br> Periode : <b> <?php if ($bulan == "01") : ?>Januari
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
                                        </b></small>

                            </address>
                        </b></center>


                </div>

                <div class="col-sm-2 ">


                </div>



            </div>



            <div class="row" style="margin: 10px;">
                <div class="col-12 table-responsive">
                    <table class="table table-hover  table-bordered">
                        <tbody>

                            <?php
                            $nomor = 1;
                            foreach ($datalaporan->getResultArray() as $row) :
                            ?>
                            <tr style="background-color: #e3f7ff;">
                                <th style="width: 2%;"><?= $nomor++ ?></th>

                                <th colspan="2">
                                    <?= $row['nama_karyawan'] ?>
                                </th>

                                <th colspan="2">
                                    <?= $row['subtotallembur'] ?> Jam
                                </th>

                            </tr>
                            <tr>

                                <?php
                                    $urutan = 1;
                                    foreach ($datadetaillaporan->getResultArray() as $rew) :
                                    ?>

                                <?php if ($row['idkaryawan'] == $rew['idkaryawan']) : ?>

                            <tr class="table-sm">
                                <td style="width: 1px; "></td>
                                <td style=" width: 2%; text-align: center;"><?= $urutan++ ?></td>

                                <td>
                                    <?= $rew['tgllembur'] ?>
                                </td>

                                <td>

                                    <?= " " ?> <?= $rew['lama_lembur'] ?> Jam
                                </td>


                                <td>

                                    <?= $rew['ket'] ?>
                                </td>

                            </tr>

                            <?php else : ?>


                            <?php endif ?>




                            <?php endforeach; ?>
                            <tr>

                            </tr>

                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3"><b>Total Semua Lembur</b></td>
                                <td colspan="2">
                                    <h5><b> <?= $totalSubtotal ?> Jam</h5></b>
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