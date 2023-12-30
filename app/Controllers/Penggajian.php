<?php

namespace App\Controllers;

use App\Models\ModelDetailGaji;
use App\Models\ModelDetailKelalian;
use App\Models\ModelGaji;
use App\Models\ModelKaryawan;
use App\Models\ModelKelalian;
use App\Models\ModelRekapInformasiKaryawan;

class Penggajian extends BaseController
{
    public function __construct()
    {
        $this->DetaiGaji =  new ModelDetailGaji();
        $this->Gaji =  new ModelGaji();
    }

    public function index()
    {

        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_penggajian', $cari);
            redirect()->to('Penggajian/index');
        } else {
            $cari = session()->get('cari_penggajian');
        }

        $totaldata = $cari ? $this->DetaiGaji->tampildata_cari($cari)->countAllResults() : $this->DetaiGaji->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->DetaiGaji->tampildata_cari($cari)->OrderBy('id_detail_gaji', 'desc')->paginate(10, 'nomor') : $this->DetaiGaji->tampildata()->OrderBy('id_detail_gaji', 'desc')->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->DetaiGaji->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('gaji/viewgaji', $data);
    }

    function datadetail()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $model = new ModelDetailGaji();
            $datadetailgaji = $model->tampildata()->OrderBy('nama_karyawan', 'asc')->getWhere(['idgaji' => $id]);

            $totalSubtotal = 0;
            foreach ($datadetailgaji->getResultArray() as $total) :
                $totalSubtotal += intval($total['total_gaji']);
            endforeach;

            $data = [
                'datadetailgaji' => $datadetailgaji,
                'total' => $totalSubtotal
            ];

            $json = [
                'data' => view('gaji/datadetail', $data),
                'totalSubtotal' => "Rp." . number_format($totalSubtotal, 0, ",", "."),
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    function datadetailperbulan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $model = new ModelDetailGaji();
            $datadetailgaji = $model->tampildata()->OrderBy('nama_karyawan', 'asc')->getWhere(['idgaji' => $id]);

            $totalSubtotal = 0;
            foreach ($datadetailgaji->getResultArray() as $total) :
                $totalSubtotal += intval($total['total_gaji']);
            endforeach;

            $data = [
                'datadetailgaji' => $datadetailgaji,
                'total' => $totalSubtotal
            ];

            $json = [
                'data' => view('gaji/datadetailperbulan', $data),
                'totalSubtotal' => "Rp." . number_format($totalSubtotal, 0, ",", "."),
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    function datadetailbonus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $model = new ModelDetailGaji();
            $datadetailgaji = $model->tampildata()->OrderBy('nama_karyawan', 'asc')->getWhere(['idgaji' => $id]);

            $totalSubtotal = 0;
            foreach ($datadetailgaji->getResultArray() as $total) :
                $totalSubtotal += intval($total['total_gaji']);
            endforeach;

            $data = [
                'datadetailgaji' => $datadetailgaji,
                'total' => $totalSubtotal
            ];

            $json = [
                'data' => view('gaji/datadetailbonus', $data),
                'totalSubtotal' => "Rp." . number_format($totalSubtotal, 0, ",", "."),
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }




    function rekapdatadetail()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $id_karyawan = $this->request->getPost('idkar');
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $tgl = '20' . $tahun . '-' . $bulan . '-' . '01';

            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $id_karyawan . '01' . $bulan . $tahun;
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            //rumus mencari data yang kan di uambildari data rekap
            $cekdatarekap = $ModelRekapInformasiKaryawan->tampildata()->find($idrekap);
            if ($cekdatarekap) {
                $Hadir_rekap_informasi = $cekdatarekap['Hadir_rekap_informasi'];
                $Absen_rekap_informasi = $cekdatarekap['Absen_rekap_informasi'];
                $Telat_rekap_informasi = $cekdatarekap['Telat_rekap_informasi'];
                $Pulangcepat_rekap_informasi = $cekdatarekap['Pulangcepat_rekap_informasi'];
                $Potongan_informasi = $cekdatarekap['Potongan_informasi'];
                $Hutang_informasi = $cekdatarekap['Hutang_informasi'];
                $Lembur_informasi = $cekdatarekap['Lembur_informasi'];
                $gajipokok__karyawan = $cekdatarekap['gajipokok__karyawan'];
                $tmakan_karyawan = $cekdatarekap['tmakan_karyawan'];
                $thadir_karyawan = $cekdatarekap['thadir_karyawan'];

                $potongantelat = intval($Telat_rekap_informasi) * 20000;
                $potongancepatpulang = intval($Pulangcepat_rekap_informasi) * 20000;
                $bonuslembur = intval($Lembur_informasi) * 10000;
                $tunjanganmakan = intval($tmakan_karyawan) * intval($Hadir_rekap_informasi);
                $tunjanganhadir = intval($thadir_karyawan) * intval($Hadir_rekap_informasi);

                if ($Absen_rekap_informasi > 3) {
                    $lebihabsen = intval($Absen_rekap_informasi) - 3;
                    $potongankehadiran = intval($lebihabsen) * 50000;
                } else {
                    $potongankehadiran = 0;
                }

                $totalgajikaryawantanpahutang = intval($gajipokok__karyawan) + intval($bonuslembur) + intval($tunjanganmakan) + intval($tunjanganhadir) - intval($potongantelat) - intval($potongancepatpulang)  - intval($Potongan_informasi) - intval($potongankehadiran);


                $iddetail = $id_karyawan . '-' . $bulan . $tahun;

                $ModelDetailGaji = new ModelDetailGaji();
                $cekdetailgaji = $ModelDetailGaji->find($iddetail);
                if ($cekdetailgaji) {
                    $json = [
                        'gagal' => "Data Gaji Sudah Ada",
                    ];
                } else {
                    $ModelDetailGaji->insert([
                        'id_detail_gaji' =>  $iddetail,
                        'idgaji' => $id,
                        'tgldetailgaji' => $tgl,
                        'idkar' =>  $id_karyawan,
                        'idrekap' =>  $idrekap,
                        'gajipokoksaatini' =>  $gajipokok__karyawan,
                        'tunj_makansaatini' =>  $tunjanganmakan,
                        'tunj_hadirsaatini' =>  $tunjanganhadir,
                        'bonus' =>  0,
                        'total_gaji' =>  $totalgajikaryawantanpahutang,
                        'gajiditerima' =>  intval($totalgajikaryawantanpahutang) - intval($Hutang_informasi),
                        'status_gaji' => "Pending"

                    ]);

                    $ModelGaji = new ModelGaji();
                    $cekrekapgaji = $ModelGaji->find($id);
                    if ($cekrekapgaji) {
                        $totalgajilama = $cekrekapgaji['total_pengeluarangaji'];
                        $ModelGaji->update($id, [
                            'total_pengeluarangaji' => intval($totalgajilama) + intval($totalgajikaryawantanpahutang),
                        ]);
                    } else {
                        $ModelGaji->insert([
                            'id_gaji' =>  $id,
                            'tgl_gaji' => $tgl,
                            'total_pengeluarangaji' =>  $totalgajikaryawantanpahutang,
                        ]);
                    }

                    $json = [
                        'success' => "Data Berhasil Disimpan $tgl",

                    ];
                }
            } else {

                $json = [
                    'gagal' => "Tidak ada data absen bulan ini",

                ];
            }

            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }


    function simpanbonus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $bonus = $this->request->getPost('bonus');
            $bonuslama = $this->request->getPost('bonuslama');
            $idgaji = $this->request->getPost('idgaji');

            $ModelDetailGaji = new ModelDetailGaji();
            $cekdetailgaji = $ModelDetailGaji->find($id);
            if ($cekdetailgaji) {
                $totalgajilama = $cekdetailgaji['total_gaji'];
                $gajiditerimalama = $cekdetailgaji['gajiditerima'];
                $ModelDetailGaji->update($id, [
                    'total_gaji' => intval($totalgajilama) + intval($bonus) - intval($bonuslama),
                    'gajiditerima' => intval($gajiditerimalama) + intval($bonus) - intval($bonuslama),
                    'bonus' => $bonus,
                ]);

                $ModelGaji = new ModelGaji();
                $cekrekapgaji = $ModelGaji->find($idgaji);
                if ($cekrekapgaji) {
                    $total_pengeluarangajilama = $cekrekapgaji['total_pengeluarangaji'];
                    $ModelGaji->update($idgaji, [
                        'total_pengeluarangaji' => intval($total_pengeluarangajilama) + intval($bonus) - intval($bonuslama),
                    ]);

                    $json = [
                        'success' => "Data Berhasil Disimpan $id $bonus $bonuslama $idgaji",

                    ];
                } else {

                    $json = [
                        'gagal' => "Data Rekap Gaji Tidak ditemukan",

                    ];
                }
            } else {

                $json = [
                    'gagal' => "Detail Gaji Tidak ditemukan",

                ];
            }
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    function acceptgaji()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $ModelDetailGaji = new ModelDetailGaji();
            $cekdetailgaji = $ModelDetailGaji->find($id);
            if ($cekdetailgaji) {
                $ModelDetailGaji->update($id, [
                    'status_gaji' => "Accept",
                ]);

                $json = [
                    'success' => "Data Berhasil Di-Accept",

                ];
            } else {

                $json = [
                    'gagal' => "Detail Gaji Tidak ditemukan",

                ];
            }
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    function pendinggaji()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $ModelDetailGaji = new ModelDetailGaji();
            $cekdetailgaji = $ModelDetailGaji->find($id);
            if ($cekdetailgaji) {
                $ModelDetailGaji->update($id, [
                    'status_gaji' => "Pending",
                ]);

                $json = [
                    'success' => "Data Berhasil Di-Pending",

                ];
            } else {

                $json = [
                    'gagal' => "Detail Gaji Tidak ditemukan",

                ];
            }
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }




    public function dataperbulan()
    {
        return view('gaji/datagajiperbulan');
    }

    public function inputbonus()
    {
        return view('gaji/forminputbonus');
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $idgaji = $this->request->getPost('idgaji');
            $totalgaji = $this->request->getPost('totalgaji');
            $bonus = $this->request->getPost('bonus');

            $ModelGaji = new ModelGaji();
            $cekrekapgaji = $ModelGaji->find($idgaji);
            if ($cekrekapgaji) {
                $totalgajilama = $cekrekapgaji['total_pengeluarangaji'];
                $ModelGaji->update($idgaji, [
                    'total_pengeluarangaji' => intval($totalgajilama) - intval($totalgaji) - intval($bonus),
                ]);
            }
            $ModelDetailGaji = new ModelDetailGaji();
            $ModelDetailGaji->delete($id);


            $json = [
                'sukses' => "Item Berhasil Terhapus $totalgajilama"
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    public function tambah()
    {

        return view('gaji/formtambahgaji');
    }

    public function simpandata()
    {

        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $kerugian = $this->request->getPost('kerugian');
        $potkelalaian = $this->request->getPost('potkelalaian');
        $keterangan = $this->request->getPost('keterangan');
        $tanggalSekarang = date('Y-m-d');
        $bulansekarang = date('Y-m');

        //membuat kode transaksi        
        $idKelalaian = sprintf('KEL-') . $idkaryawan . date('dmy', strtotime($bulansekarang));


        // validasi
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            //     'nama' => [
            //         'rules' => 'required|is_unique[barang1910005.brgkode1910005]',
            //         'label' => 'KODE BARANG',
            //         'errors' => [
            //             'required' => '{field} TIDAK BOLEH KOSONG',
            //             'is_unique' => '{field} SUDAH ADA, COBA LAGI YANG LAIN'
            //         ]
            //     ],

            //     'jabatan' => [
            //         'rules' => 'required',
            //         'label' => 'NAMA BARANG',
            //         'errors' => [
            //             'required' => '{field} TIDAK BOLEH KOSONG',

            //         ]
            //     ],

            //     'status' => [
            //         'rules' => 'required',
            //         'label' => 'status BARANG',
            //         'errors' => [
            //             'required' => '{field} TIDAK BOLEH KOSONG',
            //         ]
            //     ],

            //     'gapok' => [
            //         'rules' => 'required',
            //         'label' => 'gapok BARANG',
            //         'errors' => [
            //             'required' => '{field} TIDAK BOLEH KOSONG',
            //         ]
            //     ],

            //     'thadirbarang' => [
            //         'rules' => 'required|numeric',
            //         'label' => 'thadir BARANG',
            //         'errors' => [
            //             'required' => '{field} TIDAK BOLEH KOSONG',
            //             'numeric' => '{field} HANYA BOLEH ANGKA',
            //         ]
            //     ],

            'username' => [
                'rules' => 'required',
                'label' => 'Username',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',

                ]
            ],




        ]);

        if (!$valid) {
            $pesan = [
                'error' => '
             <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        	' . $validation->listErrors() . '
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesan);
            return redirect()->to('Kelalaian/tambah');
        } else {

            // //koding hitung dan update data Kelalaian
            $ModelKelalaian = new ModelKelalian();
            $cekdata = $ModelKelalaian->find($idKelalaian);
            if ($cekdata) {
                $subtotal_Kelalaian = $cekdata['subtotal_kelalaian'];

                // penambahan Kelalaian
                $jumlahakhir = intval($subtotal_Kelalaian) + intval($potkelalaian);

                $ModelKelalaian->update($idKelalaian, [
                    'subtotal_kelalaian' => $jumlahakhir,
                ]);
            } else {

                //simpan data  Kelalaian
                $this->Kelalaian->insert([
                    'id' => $idKelalaian,
                    'tgl' => $tanggalSekarang,
                    'subtotal_kelalaian' => $potkelalaian,
                    'id_karyawan' => $idkaryawan,

                ]);
            }


            // //koding hitung dan update data rekap karyawab
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekrekap) {
                $rekap_hutang = $cekrekap['Potongan_informasi'];
                $jumlahakhirinformasi = intval($rekap_hutang) + intval($potkelalaian);
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Potongan_informasi' => $jumlahakhirinformasi,
                ]);
            } else {

                //simpan data  rekap
                $ModelRekapInformasiKaryawan->insert([
                    'id_rekap_informasi' => $idrekap,
                    'Bulan_rekap_informasi' => $tanggalSekarang,
                    'Potongan_informasi' => $potkelalaian,
                    'id_user' => $idkaryawan,
                    'Hadir_rekap_informasi' => 0,
                    'Absen_rekap_informasi' => 0,
                    'Telat_rekap_informasi' => 0,
                    'Pulangcepat_rekap_informasi' => 0,
                    'Hutang_informasi' => 0,




                ]);
            }




            //simpan data detail Kelalaian
            $this->DetailKelalaian->insert([
                'id_kelalaian' => $idKelalaian,
                'tgl_kelalaian' => $tanggalSekarang,
                'idkaryawan_kelalain' => $idkaryawan,
                'kerugian' => $kerugian,
                'jumlah_kelalain' => $potkelalaian,
                'ket_kelalaian' => $keterangan


            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data Kelalaian ' . $nama . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Kelalaian/index');
        }
    }

    public function updatedata()
    {
        $iddetail = $this->request->getPost('iddetail');
        $idkelalaian = $this->request->getPost('idkelalaian');
        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $kerugian = $this->request->getPost('kerugian');
        $potkelalaian = $this->request->getPost('potkelalaian');
        $potkelalaianawal = $this->request->getPost('potkelalaianawal');
        $keterangan = $this->request->getPost('keterangan');

        //update data  master Kelalaian
        $ModelKelalaian = new ModelKelalian();
        $cekdata = $ModelKelalaian->find($idkelalaian);

        if ($cekdata) {
            $subtotal_Kelalaian = $cekdata['subtotal_kelalaian'];

            // penambahan Kelalaian
            $jumlahakhir = intval($subtotal_Kelalaian) - intval($potkelalaianawal)  + intval($potkelalaian);

            $ModelKelalaian->update($idkelalaian, [
                'subtotal_kelalaian' => $jumlahakhir,

            ]);

            //update data rekap
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekdata = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekdata) {
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Potongan_informasi' => $jumlahakhir,
                ]);
            }

            //update data  detail Kelalaian

            $this->DetailKelalaian->update($iddetail, [
                'kerugian' => $kerugian,
                'jumlah_kelalain' => $potkelalaian,
                'ket_kelalaian' => $keterangan

            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $nama . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Kelalaian/index');
        }
    }

    function edit($id)
    {
        $ModelDetailKelalaian = new ModelDetailKelalian();
        $ModelKaryawan = new ModelKaryawan();
        $cekid = $ModelDetailKelalaian->find($id);


        if ($cekid) {
            $idkaryawan = $cekid['idkaryawan_kelalain'];
            $cekkaryawan = $ModelKaryawan->find($idkaryawan);
            $namakaryawan = $cekkaryawan['nama_karyawan'];

            $data = [

                'id' => $id,
                'idkaryawan' => $idkaryawan,
                'namakaryawan' => $namakaryawan,
                'tgl_Kelalaian' => $cekid['tgl_kelalaian'],
                'id_Kelalaian' => $cekid['id_kelalaian'],
                'jumlah_kelalain' => $cekid['jumlah_kelalain'],
                'ket_kelalaian' => $cekid['ket_kelalaian'],
                'kerugian' => $cekid['kerugian'],

            ];

            return view('kelalaian/formeditKelalaian', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }
}