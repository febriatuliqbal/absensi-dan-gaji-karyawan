<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MA. Advertising|Slip Gaji Karyawan</title>

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
                        <small class="float-right"><b>SLIP GAJI KARYAWAN</b></small>
                    </h2>
                </div>

            </div>



            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        Jl. DR. Wahidin no. 17 (Samping KORAMIL 02 Padang Timur)
                        Ganting Parak Gadang Kota Padang
                        <br> Email: mas.anif.maju@gmail.com
                        <br> HP/WA : 0813 6310 9625 / 0822 1869 1311

                    </address>
                </div>

                <div class="col-sm-3 invoice-col">

                    <address>
                        <b>Nama:</b>
                        <br><?= $nama_karyawan ?>
                        <br><b>Jabatan:</b>
                        <br><?= $jabatan_karyawan ?>
                        <br><b>Kode Gaji:</b>
                        <br><?= $id ?>

                    </address>
                </div>

                <div class="col-sm-2 invoice-col">

                    <address>
                        <b>Periode:</b>
                        <br>
                        <?= date('F', strtotime($tgldetailgaji)) . " " . date('Y', strtotime($tgldetailgaji))  ?>
                        <br><b>Hari Kerja:</b>
                        <br> <?= intval($Hadir_rekap_informasi) + intval($Absen_rekap_informasi) ?>
                        <br><b>Kehadiran:</b>
                        <br> <?= intval($Hadir_rekap_informasi) ?>

                    </address>
                </div>



            </div>

            <div class="row">
                <div class="col-6 table-responsive">
                    <b>Penghasilan</b>
                    <table class="table table-striped">

                        <tbody>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td>Rp. <?= number_format($gajipokoksaatini, 0) ?>

                                </td>

                            </tr>
                            <tr>
                                <td>Tunj. Makan</td>
                                <td>Rp. <?= number_format($tunj_makansaatini, 0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Tunj. Kehadiran</td>
                                <td>Rp. <?= number_format($tunj_hadirsaatini, 0) ?></td>
                            </tr>
                            <tr>
                                <td>U. Lembur</td>
                                <td>Rp. <?= number_format($Lembur_informasi * 10000, 0) ?></td>
                            </tr>
                            <tr>
                                <td>Bonus</td>
                                <td>Rp. <?= number_format($bonus, 0) ?></td>
                            </tr>

                            <tr>

                                <td> <b>Jumlah Penghasilan</b></td>
                                <td><b>Rp.
                                        <?= number_format($bonus + $gajipokoksaatini + $tunj_makansaatini + $tunj_hadirsaatini + $Lembur_informasi * 10000, 0) ?></b>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="col-6 table-responsive">
                    <b>Potongan</b>
                    <table class="table table-striped">

                        <tbody>
                            <tr>
                                <td>Keterlambatan</td>
                                <td>Rp. <?= number_format($Telat_rekap_informasi * 20000, 0) ?>

                                </td>

                            </tr>
                            <tr>
                                <td>Pulang Awal</td>
                                <td>Rp. <?= number_format($Pulangcepat_rekap_informasi * 20000, 0) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Kehadiran</td>
                                <td><?php if (intval($Absen_rekap_informasi) > 3) :
                                        $potongankehadiran = intval($Absen_rekap_informasi - 3 * 50000)
                                    ?>
                                    <br> <b> Rp. <?= number_format($potongankehadiran, 0) ?></b>
                                    <?php else :
                                        $potongankehadiran = 0 ?>

                                    Rp.0
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Potongan Kelalaian</td>
                                <td>Rp. <?= number_format($Potongan_informasi, 0) ?></td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                            </tr>

                            <tr>

                                <td> <b>Jumlah Potongan</b></td>
                                <td><b>Rp.
                                        <?= number_format($Telat_rekap_informasi * 20000 + $Pulangcepat_rekap_informasi * 20000 + $Potongan_informasi + $potongankehadiran, 0) ?></b>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>


            </div>

            <div class="row">

                <div class="col-12">

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Total Gaji:</th>
                                <td>Rp. <?= number_format($total_gaji, 0) ?></td>


                            </tr>
                            <tr>
                                <th>Hutang</th>
                                <td>Rp. <?= number_format($Hutang_informasi, 0) ?></td>
                            </tr>
                            <tr>
                                <th>Gaji Yang Diterima</th>
                                <td>
                                    <h4><b>Rp. <?= number_format($gajiditerima, 0) ?></h4>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>

            </div>
            <br><br><br>

            <div class="row ">

                <div class="col-6">
                </div>
                <div class="col-6"> Padang, <?= date("d-F-Y") ?></div>
                <div class="col-6">

                </div>

                <div class="col-3">

                    Diserahkan Oleh
                    <br><br><br><br>
                    Admin
                </div>
                <div class="col-3">
                    Diterima Oleh
                    <br><br><br><br>
                    <?= $nama_karyawan ?>
                </div>

            </div>





        </section>

    </div>


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script>
    window.addEventListener("load", window.print());
    </script>
</body>

</html>