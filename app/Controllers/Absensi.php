<?php

namespace App\Controllers;

use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelJamKerja;
use App\Models\ModelKaryawan;
use App\Models\ModelRekapInformasiKaryawan;
use CodeIgniter\I18n\Time;

class Absensi extends BaseController
{
    public function __construct()
    {
        $this->ModelAbsensi =  new ModelInputAbsensiKaryawan();
        $this->Modelrekap =  new ModelRekapInformasiKaryawan();
    }

    public function index()
    {
        $model = new ModelKaryawan();

        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_absensi', $cari);
            redirect()->to('absensi/index');
        } else {
            $cari = session()->get('cari_absensi');
        }

        $totaldata = $cari ? $this->ModelAbsensi->tampildata_cari($cari)->countAllResults() : $this->ModelAbsensi->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->ModelAbsensi->tampildata_cari($cari)->OrderBy('tgl_absensi', 'desc')->paginate(10, 'nomor') : $this->ModelAbsensi->tampildata()->OrderBy('tgl_absensi', 'desc')->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->ModelAbsensi->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('absensi/viewabsensi', $data);
    }

    public function dataperbulan()
    {


        $tombolcari = $this->request->getPost('tombolcari');
        $bulanini = date('m');
        $tahunini = date('Y');

        if (isset($tombolcari)) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');
            session()->set('bulan', $bulan);
            redirect()->to('absensi/dataperbulan');
        } else {
            $bulan = $bulanini;
            $tahun = $tahunini;
        }

        $totaldata = $bulan ? $this->ModelAbsensi->cari_berdasarkan_bln_thn($bulan, $tahun)->countAllResults() : $this->ModelAbsensi->cari_berdasarkan_bln_thn($bulanini, $tahun)->countAllResults();
        $dataRekap = $bulan ? $this->Modelrekap->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('Bulan_rekap_informasi', 'desc')->paginate(10, 'nomor') : $this->Modelrekap->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('Bulan_rekap_informasi', 'desc')->paginate(10, 'nomor');
        $datadetailAbsensi = $bulan ? $this->ModelAbsensi->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgl_absensi', 'desc')->findall() : $this->ModelAbsensi->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgl_absensi', 'desc')->findall();
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $dataRekap,
            'tampildatadetail' => $datadetailAbsensi,
            'pager' => $this->Modelrekap->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'bulan' => $bulan,
            'tahun' => $tahun


        ];
        return view('absensi/dataabsensiperbulan', $data);
    }

    public function dataabsensiperhari()
    {

        return view('absensi/dataabsensiperhari');
    }

    public function detailabsensi()
    {
        if ($this->request->isAJAX()) {

            $tanggal = $this->request->getPost('tanggal');


            $model = new ModelInputAbsensiKaryawan();
            $datadetailgaji = $model->tampildata()->orLike('tgl_absensi', $tanggal)->get();


            $data = [
                'datadetailabsensi' => $datadetailgaji,
                // 'total' => $totalSubtotal
            ];

            $json = [
                'data' => view('absensi/dataabsensi', $data),
                // 'totalSubtotal' => "Rp." . number_format($totalSubtotal, 0, ",", "."),
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $tgl = $this->request->getPost('tgl');
            $username = $this->request->getPost('username');


            $ModelInputAbsensiKaryawan = new ModelInputAbsensiKaryawan();

            $ModelInputAbsensiKaryawan->delete($id);

            $idabsensi =  $username . '-20' . date('ym', strtotime($tgl));

            //mendapatan jumlah rekap absensi bulan ini
            $modelEstimasi = new ModelInputAbsensiKaryawan();
            $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
            $totaldataabsen = count($dataabsen);
            $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
            $totaldatterlambat = count($dataterlambat);
            $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
            $totaldatacepatpulang = count($dataacepatpulang);
            $datahadir = $modelEstimasi->tampildata()->OrLike('id_absensi', $idabsensi)->get()->getResult();
            $totaldatahadir = count($datahadir) - $totaldataabsen;


            //koding hitung  data rekap karyawab

            $idrekap = sprintf('REK-') . $username . '01' . date('my', strtotime($tgl));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $ModelRekapInformasiKaryawan->update($idrekap, [
                'Hadir_rekap_informasi' => $totaldatahadir,
                'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
                'Telat_rekap_informasi' => $totaldatterlambat,
                'Absen_rekap_informasi' => $totaldataabsen,
            ]);

            $json = [
                'sukses' => 'Item Berhasil Terhapus'
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    public function tambah()
    {

        return view('absensi/formtambahabsensi');
    }

    public function simpandata()
    {

        $tgl = $this->request->getPost('tgl');
        $username = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jamkerja = $this->request->getPost('jamkerja');
        $jammasuk = $this->request->getPost('jammasuk');
        $keterangan = $this->request->getPost('keterangan');

        //membuat kode transaksi lanjut terus 1-2-3-4


        $id_absensi = $username . "-" . date('Ymd', strtotime($tgl));

        $cekdata = $this->ModelAbsensi->find($id_absensi);
        if ($cekdata) {
            $pesan = [
                'error' => '
         <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            Data Absensi Sudah Ada
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> '

            ];

            session()->setFlashdata($pesan);
            return redirect()->to('Absensi/tambah');
        } else {

            // validasi
            $validation = \Config\Services::validation();

            $valid = $this->validate([

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
                        'is_unique' => "{field} "

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
                return redirect()->to('Absensi/tambah');
            } else {

                //rumus mencari data yang kan di update manual manggunakan php
                $modelInputAbsensi = new ModelInputAbsensiKaryawan();
                $cekdata = $modelInputAbsensi->find($id_absensi);



                $modeljamkerja = new ModelJamKerja();
                $cekjamkerja = $modeljamkerja->find($jamkerja);

                if ($cekjamkerja) {
                    $masukjamkerja = $cekjamkerja['jammasuk'];
                }

                //rumus perhitungan jarak waktu
                $jamseharusnyamasuk = new Time($masukjamkerja);
                $waktumasuk = new Time($jammasuk);
                $interval = $jamseharusnyamasuk->diff($waktumasuk);
                $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

                if ($interval->invert == 1) {
                    $seconds = -$seconds;
                } else {
                    $seconds = $seconds;
                }

                if ($seconds < 600) {
                    $status = "Tepat Waktu";
                    $jumlahterlambat = 0;
                } else {
                    $status = "Terlambat";
                    $jumlahterlambat = 1;
                }


                $this->ModelAbsensi->insert([
                    'id_absensi' => $id_absensi,
                    'id_karyawan' => $username,
                    'tgl_absensi' => $tgl,
                    'shift' => $jamkerja,
                    'jam_masuk' => $jammasuk,
                    'jam_pulang' => "",
                    'lokasi_masuk' => "",
                    'lokasi_pulang' => "",
                    'foto_masuk' => "fotokosong.png",
                    'foto_kaluar' => "fotokosong.png",
                    'keterangan' => $keterangan,
                    'status' => $status,

                ]);


                $idabsensi =  $username . '-20' . date('ym', strtotime($tgl));

                //mendapatan jumlah rekap absensi bulan ini
                $modelEstimasi = new ModelInputAbsensiKaryawan();
                $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
                $totaldataabsen = count($dataabsen);
                $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
                $totaldatterlambat = count($dataterlambat);
                $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
                $totaldatacepatpulang = count($dataacepatpulang);
                $datahadir = $modelEstimasi->tampildata()->OrLike('id_absensi', $idabsensi)->get()->getResult();
                $totaldatahadir = count($datahadir) - $totaldataabsen;


                //koding hitung  data rekap karyawab

                $idrekap = sprintf('REK-') . $username . '01' . date('my', strtotime($tgl));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Hadir_rekap_informasi' => $totaldatahadir,
                    'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
                    'Telat_rekap_informasi' => $totaldatterlambat,
                    'Absen_rekap_informasi' => $totaldataabsen,
                ]);


                $pesanSukses = [
                    'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $idrekap . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

                ];

                session()->setFlashdata($pesanSukses);
                return redirect()->to('Absensi/index');
            }
        }
    }



    public function tambahpulang()
    {

        return view('absensi/formtambahabsensipulang');
    }




    public function simpandatapulang()
    {

        $tgl = $this->request->getPost('tgl');
        $username = $this->request->getPost('username');
        $jampulang = $this->request->getPost('jampulang');
        $keterangan = $this->request->getPost('keterangan');

        //membuat kode transaksi lanjut terus 1-2-3-4


        $id_absensi = $username . "-" . date('Ymd', strtotime($tgl));



        $cekdata = $this->ModelAbsensi->find($id_absensi);
        if ($cekdata) {


            // validasi
            $validation = \Config\Services::validation();

            $valid = $this->validate([

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
                        'is_unique' => "{field} "

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
                return redirect()->to('Absensi/tambahpulang');
            } else {

                $modelInputAbsensi = new ModelInputAbsensiKaryawan();
                $cekdata = $modelInputAbsensi->find($id_absensi);

                if ($cekdata) {

                    $shift = $cekdata['shift'];
                    $statuslama = $cekdata['status'];



                    $modeljamkerja = new ModelJamKerja();
                    $cekjamkerja = $modeljamkerja->find($shift);

                    if ($cekjamkerja) {
                        $keluarjamkerja = $cekjamkerja['jamkeluar'];



                        $jamseharusnyakeluar = new Time($keluarjamkerja);
                        $jamkeluar = new Time($jampulang);
                        $interval = $jamseharusnyakeluar->diff($jamkeluar);
                        $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

                        if ($interval->invert == 1) {
                            $seconds = -$seconds;
                        } else {
                            $seconds = $seconds;
                        }

                        if ($seconds < -1) {
                            $status = "Cepat Pulang";

                            if ($statuslama == "Terlambat") {
                                //jaki ada menggunakan beberapa rumus di php maka kita update 2 kali datanya
                                $modelInputAbsensi->update($id_absensi, [
                                    'status' => $statuslama . '-' . $status,
                                ]);
                            } else {
                                $modelInputAbsensi->update($id_absensi, [
                                    'status' => $status,
                                ]);
                            }
                        } else {
                            if ($statuslama == "Terlambat") {
                                //jaki ada menggunakan beberapa rumus di php maka kita update 2 kali datanya
                                $modelInputAbsensi->update($id_absensi, [
                                    'status' => $statuslama,
                                ]);
                            } else {
                                $modelInputAbsensi->update($id_absensi, [
                                    'status' => "Tepat Waktu",
                                ]);
                            }
                        }
                    }
                }

                //rumus perhitungan jarak waktu



                $this->ModelAbsensi->update($id_absensi, [
                    'jam_pulang' => $jampulang,
                    'keterangan' => $keterangan,

                ]);


                $idabsensi =  $username . '-20' . date('ym', strtotime($tgl));

                //mendapatan jumlah rekap absensi bulan ini
                $modelEstimasi = new ModelInputAbsensiKaryawan();
                $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
                $totaldataabsen = count($dataabsen);
                $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
                $totaldatterlambat = count($dataterlambat);
                $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
                $totaldatacepatpulang = count($dataacepatpulang);
                $datahadir = $modelEstimasi->tampildata()->OrLike('id_absensi', $idabsensi)->get()->getResult();
                $totaldatahadir = count($datahadir) - $totaldataabsen;


                //koding hitung  data rekap karyawab

                $idrekap = sprintf('REK-') . $username . '01' . date('my', strtotime($tgl));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Hadir_rekap_informasi' => $totaldatahadir,
                    'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
                    'Telat_rekap_informasi' => $totaldatterlambat,
                    'Absen_rekap_informasi' => $totaldataabsen,
                ]);


                $pesanSukses = [
                    'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $idrekap . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

                ];

                session()->setFlashdata($pesanSukses);
                return redirect()->to('Absensi/index');
            }
        } else {
            $pesan = [
                'error' => '
         <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            Data Absensi Masuk Belum Ada
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> '

            ];

            session()->setFlashdata($pesan);
            return redirect()->to('Absensi/tambahpulang');
        }
    }

    public function tambahizin()
    {

        return view('absensi/formtambahabsensiizin');
    }

    public function simpandataizin()
    {

        $tgl = $this->request->getPost('tgl');
        $username = $this->request->getPost('username');

        $keterangan = $this->request->getPost('keterangan');

        //membuat kode transaksi lanjut terus 1-2-3-4


        $id_absensi = $username . "-" . date('Ymd', strtotime($tgl));

        $cekdata = $this->ModelAbsensi->find($id_absensi);
        if ($cekdata) {
            $pesan = [
                'error' => '
         <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            Data Absensi Sudah Ada
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div> '

            ];

            session()->setFlashdata($pesan);
            return redirect()->to('Absensi/tambahizin');
        } else {

            // validasi
            $validation = \Config\Services::validation();

            $valid = $this->validate([

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
                        'is_unique' => "{field} "

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
                return redirect()->to('Absensi/tambahizin');
            } else {

                $this->ModelAbsensi->insert([
                    'id_absensi' => $id_absensi,
                    'id_karyawan' => $username,
                    'tgl_absensi' => $tgl,
                    'shift' => "Shift 1",
                    'jam_masuk' => "",
                    'jam_pulang' => "",
                    'lokasi_masuk' => "",
                    'lokasi_pulang' => "",
                    'foto_masuk' => "fotokosong.png",
                    'foto_kaluar' => "fotokosong.png",
                    'keterangan' => $keterangan,
                    'status' => "Izin",

                ]);


                $idabsensi =  $username . '-20' . date('ym', strtotime($tgl));

                //mendapatan jumlah rekap absensi bulan ini
                $modelEstimasi = new ModelInputAbsensiKaryawan();
                $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
                $totaldataabsen = count($dataabsen);
                $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
                $totaldatterlambat = count($dataterlambat);
                $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
                $totaldatacepatpulang = count($dataacepatpulang);
                $datahadir = $modelEstimasi->tampildata()->OrLike('id_absensi', $idabsensi)->get()->getResult();
                $totaldatahadir = count($datahadir) - $totaldataabsen;


                //koding hitung  data rekap karyawab

                $idrekap = sprintf('REK-') . $username . '01' . date('my', strtotime($tgl));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Hadir_rekap_informasi' => $totaldatahadir,
                    'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
                    'Telat_rekap_informasi' => $totaldatterlambat,
                    'Absen_rekap_informasi' => $totaldataabsen,
                ]);


                $pesanSukses = [
                    'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $idrekap . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

                ];

                session()->setFlashdata($pesanSukses);
                return redirect()->to('Absensi/index');
            }
        }
    }


    public function updatedata()
    {
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $jabatan = $this->request->getPost('jabatan');
        $status = $this->request->getPost('status');
        $gapok = $this->request->getPost('gapok');
        $tmakan = $this->request->getPost('tmakan');
        $thadir = $this->request->getPost('thadir');
        $alamat = $this->request->getPost('alamat');
        $username = $this->request->getPost('username');



        // validasi
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'GAMBAR',
                'errors' => [
                    'mime_in' => 'FORMAT FILE {field} SALAH, PASTIKAN FORMATNYA (png,jpg,jpeg)'
                ]
            ]


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
            return redirect()->to('Karyawan/edit/' . $id);
        } else {
            $cekdata = $this->karyawan->find($id);
            $patGambarLama = $cekdata['foto_karyawan'];
            $gambar = $_FILES['gambar']['name'];

            if ($gambar != NULL) {
                ($patGambarLama == '' || $patGambarLama == null) ? '' :    unlink('uploud/' . $patGambarLama);

                $namafilegambar = $nama;
                $filegambar = $this->request->getFile('gambar');
                $filegambar->move('uploud', $namafilegambar . '.' . $filegambar->getExtension());

                $patGambar = $filegambar->getName();
            } else {
                $patGambar = $patGambarLama;
            }
            $this->karyawan->update($id, [
                'nama_karyawan' => $nama,
                'jabatan_karyawan' => $jabatan,
                'status_karyawan' => $status,
                'gajipokok__karyawan' => $gapok,
                'tmakan_karyawan' => $thadir,
                'thadir_karyawan' => $tmakan,
                'alamat_karyawan' => $alamat,
                'username_karyawan' => $username,
                'foto_karyawan' => $patGambar

            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $nama . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Karyawan/index');
        }
    }

    function edit($id)
    {
        $ModelKaryawan = new ModelKaryawan();
        $cekid = $ModelKaryawan->find($id);


        if ($cekid) {

            $data = [
                'id' => $id,
                'nama_karyawan' => $cekid['nama_karyawan'],
                'jabatan_karyawan' => $cekid['jabatan_karyawan'],
                'status_karyawan' => $cekid['status_karyawan'],
                'gajipokok__karyawan' => $cekid['gajipokok__karyawan'],
                'tmakan_karyawan' => $cekid['tmakan_karyawan'],
                'thadir_karyawan' => $cekid['thadir_karyawan'],
                'alamat_karyawan' => $cekid['alamat_karyawan'],
                'username_karyawan' => $cekid['username_karyawan'],
                'foto_karyawan' => $cekid['foto_karyawan'],
            ];

            return view('karyawan/formeditkaryawan', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }
}