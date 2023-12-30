<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MA. Advertising|Laporan Rekap Absensi Karyawan</title>

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
                                <h3><b>Laporan Rekap Absensi Karyawan Perbulan</b>
                                    <br><small><?php if ($bulan2 == "01") : ?>
                                        Januari
                                        <?php elseif ($bulan2 == "02") : ?> Februari
                                        <?php elseif ($bulan2 == "03") : ?> Maret
                                        <?php elseif ($bulan2 == "04") : ?> April
                                        <?php elseif ($bulan2 == "05") : ?> Mei
                                        <?php elseif ($bulan2 == "06") : ?> Juni
                                        <?php elseif ($bulan2 == "07") : ?> Juli
                                        <?php elseif ($bulan2 == "08") : ?> Agustus
                                        <?php elseif ($bulan2 == "09") : ?> September
                                        <?php elseif ($bulan2 == "10") : ?> Oktober
                                        <?php elseif ($bulan2 == "11") : ?> November
                                        <?php elseif ($bulan2 == "12") : ?> Desember
                                        <?php endif ?>
                                        <?= $tahun2 ?></small>
                                    <h4>
                            </address>
                        </b></center>


                </div>

                <div class="col-sm-2 ">


                </div>



            </div>

            <div class="row" style="margin: 10px;">
                <div class="col-12 table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 3%;" scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Hadir</th>
                                <th scope="col">Absen/Izin</th>
                                <th scope="col">Telat</th>
                                <th scope="col">Pulang Awal</th>
                                <th scope="col">Lembur</th>

                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $nomor = 1;
                            foreach ($datalaporan->getResultArray() as $row) :
                            ?>
                            <tr>
                                <td><?= $nomor++ ?></td>




                                <td>
                                    <?= $row['nama_karyawan'] ?>
                                </td>
                                <td>
                                    <?= $row['Hadir_rekap_informasi'] ?>
                                </td>
                                <td>
                                    <?= $row['Absen_rekap_informasi'] ?>
                                </td>
                                <td>
                                    <?= $row['Telat_rekap_informasi'] ?>
                                </td>
                                <td>
                                    <?= $row['Pulangcepat_rekap_informasi'] ?>
                                </td>
                                <td>
                                    <?= $row['Lembur_informasi'] ?>
                                </td>

                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>





            </div>


            <br><br>
            <div class="row ">

                <div class="col-8">
                </div>
                <div class="col-4 ">
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


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script>
    // window.addEventListener("load", window.print());
    </script>
</body>

</html>