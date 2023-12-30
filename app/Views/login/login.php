<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>MA. Adv | Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url() ?>/assets/img/logomabaru.png" rel="icon">
    <link href="<?= base_url() ?>/assetslogin/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url() ?>/assetslogin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assetslogin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assetslogin/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assetslogin/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assetslogin/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url() ?>/assetslogin/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: eNno
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>



    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-1 order-lg-1 hero-img">
                    <img src="<?= base_url() ?>/assetslogin/img/hero-img.png" class="img-fluid animated" alt="">
                </div>

                <div class="col-lg-5 pt-5 pt-lg-0 order-2 order-lg-2 d-flex flex-column justify-content-center">


                    <div class="card mb-3" style=" box-shadow: 5px 5px 10px 5px rgba(0,0,0,0.2); ">

                        <div class="card-body" style="margin: 1rem;">

                            <div class="pt-4 pb-2">
                                <center><img style="max-width: 15rem;" src="<?= base_url() ?>/assets/img/logomaadv.png"
                                        alt=""></center>
                                <br>
                                <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                                <p class="text-center small">Masukan username &amp; password kamu untuk login</p>
                                <p class="text-center small" style="color: red;"><b>
                                        <?= session()->getFlashdata('sesion'); ?></b></p>
                            </div>
                            <?= form_open('login/cekuser'); ?>
                            <?= csrf_field(); ?>

                            <form class="row g-3 needs-validation" validate="">
                                <div class="col-12">
                                    <label for="yourUsername" class="form-label">Username</label>
                                    <div class="input-group has-validation">
                                        <input type="text" name="iduser" class="form-control" id="iduser"
                                            placeholder="Masukan Username Anda" required autofocus>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>
                                </div>
                                <br>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Password</label>
                                    <input type="password" name="pass" class="form-control" id="pass"
                                        placeholder="Masukan Password Anda" required="">

                                </div>

                                <div class="col-12">

                                </div>
                                <br>
                                <div class="col-12">
                                    <button class="btn btn-get-started scrollto" type="submit"
                                        style="width: 100%;">Login</button>
                                </div>
                                <div class="col-12">

                                </div>






                            </form>

                            <?= form_close(); ?>

                        </div>
                    </div>




                </div>




            </div>
        </div>

    </section><!-- End Hero -->


    <!-- ======= Footer ======= -->
    <footer id="footer" style="margin-top: 3rem;">


        <div class="container footer-bottom clearfix">

            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/enno-free-simple-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url() ?>/assetslogin/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?= base_url() ?>/assetslogin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assetslogin/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?= base_url() ?>/assetslogin/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url() ?>/assetslogin/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url() ?>/assetslogin/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url() ?>/assetslogin/js/main.js"></script>

</body>

</html>