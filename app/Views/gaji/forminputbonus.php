<?= $this->extend('tamplate/layout') ?>


<?= $this->section('judul') ?>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">

            <h1> <b>Input Bonus & Accept Gaji</b> </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Gaji</a></li>
                    <li class="breadcrumb-item active">Input Bonus & Accept Gaji</li>
                </ol>
            </nav>
        </div>

    </div>
</div>
</div><!-- End Page Title -->

<?= $this->endSection('judul') ?>


<?= $this->section('isi') ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Isi data gaji</h5>

        <?= session()->getFlashdata('error'); ?>
        <?= session()->getFlashdata('sukses'); ?>

        <div class="row mb-3" style="margin-top: -20px;">
            <div class="col-sm-4">
                <label for="inputNumber" class="col-sm-4 col-form-label">Bulan</label>
                <select style="margin-right: 15px;" name="bulan" id="bulan" class="form-select"
                    aria-label="Default select example">
                    <option value="<?= date('m') ?>">

                        <?php if (date('m') == "01") : ?> Januari
                        <?php elseif (date('m') == "02") : ?> Februari
                        <?php elseif (date('m') == "03") : ?> Maret
                        <?php elseif (date('m') == "04") : ?> April
                        <?php elseif (date('m') == "05") : ?> Mei
                        <?php elseif (date('m') == "06") : ?> Juni
                        <?php elseif (date('m') == "07") : ?> Juli
                        <?php elseif (date('m') == "08") : ?> Agustus
                        <?php elseif (date('m') == "09") : ?> September
                        <?php elseif (date('m') == "10") : ?> Oktober
                        <?php elseif (date('m') == "11") : ?> November
                        <?php elseif (date('m') == "12") : ?> Desember
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
            </div>
            <div class="col-sm-4">
                <label for="inputNumber" class="col-sm-4 col-form-label">Tahun</label>
                <select style="margin-right: 15px;" name="tahun" id="tahun" class="form-select"
                    aria-label="Default select example">

                    <option value="<?= date('y') ?>"><?= date('Y') ?></option>
                    <option value="21">2021</option>
                    <option value="22">2022</option>
                    <option value="23">2023</option>
                    <option value="24">2024</option>
                    <option value="25">2025</option>
                    <option value="26">2026</option>
                    <option value="27">2027</option>
                    <option value="28">2028</option>
                    <option value="29">2029</option>
                    <option value="30">2030</option>
                    <option value="31">2031</option>
                    <option value="32">2032</option>
                    <option value="33">2032</option>
                    <option value="34">2034</option>
                    <option value="35">2035</option>
                    <option value="36">2036</option>
                    <option value="37">2037</option>
                    <option value="38">2038</option>
                    <option value="39">2039</option>
                    <option value="40">2040</option>
                </select>
            </div>
            <div class="col-sm-4" style="margin-bottom: 10px;">
                <label for="inputText" class="col-form-label">Kode Gaji</label>
                <input id="idgaji" name="idgaji" type="text" class="form-control">
            </div>
        </div>



        <div class="row mb-3" style="margin-top: -20px;">

            <div class="col-sm-4" style="margin-bottom: 10px;">
                <label for="inputText" class="col-sm-7 col-form-label">Nama Karyawan</label>
                <input id="nama" name="nama" type="text" class="form-control" readonly>
                <input id="iddetail" name="iddetail" type="text" class="form-control" hidden>
                <input id="bonuslama" name="bonuslama" type="text" class="form-control" hidden>

            </div>

            <div class="col-sm-4" style="margin-bottom: 10px;">
                <label for="inputText" class="col-sm-7 col-form-label">Bonus</label>
                <input id="bonus" name="bonus" type="number" class="form-control">

            </div>


            <div class="col-sm-4">
                <label for="inputText" class="col-sm-7 col-form-label" style="color: white;">.</label>
                <button type="button" style="width: 100%;" class="btn btn-m btn-success" id="tombolrekap"
                    name="tombolrekap">
                    <i class="bi bi-save2"> </i> Simpan Bonus
            </div>


        </div>

        <div class="row mb-3" style="margin-top: -20px;">
            <label for="inputText" class="col-sm-2 col-form-label">Total Pengeluaran Gaji Bulan Ini :</label>
            <div class="col-sm-4" style="margin-bottom: 10px;">

                <b><input id="gajibulanini" name="gajibulanini" type="text"
                        style="color: black; font-size:  25px; border: 0px;" class="form-control" readonly></b>

            </div>



        </div>



        <div class="row" id="tampildatadetail"></div>







        <!-- <-- End General Form Elements -->

    </div>

    <div class="viewmodal" style="display: none;"> </div>


</div>


<script>
$('#tombolcari').click(function(e) {
    e.preventDefault();


    $.ajax({
        url: "<?= base_url() ?>/Karyawan/modaldatakaryawan",

        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modaldatakaryawan').modal('show');
            }
        }

    });

});

$('#tombolrekap').click(function(e) {
    e.preventDefault();


    let iddetail = $('#iddetail').val();
    let bonus = $('#bonus').val();
    let bonuslama = $('#bonuslama').val();
    let idgaji = $('#idgaji').val();
    // validasi
    if (iddetail.length == 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oppss....',
            text: 'Pilih Data Gaji Karyawan Yang Akan diniput bonusnya',

        })


    } else {

        $.ajax({
            type: "post",
            url: "<?= base_url() ?>/Penggajian/simpanbonus",
            data: {
                id: iddetail,
                idgaji: idgaji,
                bonus: bonus,
                bonuslama: bonuslama,

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






});

$('#bulan').change(function(e) {

    buatNoidGaji()
});

$('#tahun').change(function(e) {

    buatNoidGaji()
});

function buatNoidGaji() {


    let bulan = $('#bulan').val();
    let tahun = $('#tahun').val();

    $('#idgaji').val('GAJ-' +
        bulan + tahun);

    getdatadetail()


}

function kosong() {
    $('#iddetail').val("");
    $('#bonus').val("");
    $('#bonuslama').val("");
    $('#nama').val("");

}



function getdatadetail() {
    let idgaji = $('#idgaji').val();
    $.ajax({
        type: "post",
        url: "<?= base_url() ?>/Penggajian/datadetailbonus",
        data: {
            id: idgaji
        },
        dataType: "json",
        beforeSend: function() {
            $('#tampildatadetail').html(
                "<i class='fa fa-spin fa-spinner'></i> &nbsp&nbsp  Mohon Tunggu");
        },
        success: function(response) {
            if (response.data) {
                $('#tampildatadetail').html(response.data);
                $('#gajibulanini').val(response.totalSubtotal);


            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
            alert("Gagal")
        }
    });
}



//mangaktifkan tampilan side bar
$(document).ready(function() {
    $('#gaji').removeClass('collapsed');
    $('#gaji-nav').addClass('show');
    $('#inputbonus').addClass('active');
    buatNoidGaji()
    //$('#body').addClass('toggle-sidebar')



});
</script>



<?= $this->endSection('isi') ?>