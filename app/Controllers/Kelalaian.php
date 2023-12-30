<?php

namespace App\Controllers;


use App\Models\ModelDetailKelalian;
use App\Models\ModelKaryawan;
use App\Models\ModelKelalian;
use App\Models\ModelRekapInformasiKaryawan;

class Kelalaian extends BaseController
{
    public function __construct()
    {
        $this->DetailKelalaian =  new ModelDetailKelalian();
        $this->Kelalaian =  new ModelKelalian();
    }

    public function index()
    {


        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_Kelalaian', $cari);
            redirect()->to('Kelalaian/index');
        } else {
            $cari = session()->get('cari_Kelalaian');
        }

        $totaldata = $cari ? $this->DetailKelalaian->tampildata_cari($cari)->countAllResults() : $this->DetailKelalaian->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->DetailKelalaian->tampildata_cari($cari)->OrderBy('id_detail_Kelalaian', 'desc')->paginate(10, 'nomor') : $this->DetailKelalaian->tampildata()->OrderBy('id_detail_Kelalaian', 'desc')->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->DetailKelalaian->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('kelalaian/viewkelalaian', $data);
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
            redirect()->to('Kelalaian/dataKelalaianperbulan');
        } else {
            $bulan = $bulanini;
            $tahun = $tahunini;
        }

        $totaldata = $bulan ? $this->DetailKelalaian->cari_berdasarkan_bln_thn($bulan, $tahun)->countAllResults() : $this->DetailKelalaian->cari_berdasarkan_bln_thn($bulanini, $tahun)->countAllResults();
        $dataKelalaian = $bulan ? $this->Kelalaian->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgl', 'desc')->paginate(10, 'nomor') : $this->Kelalaian->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgl', 'desc')->paginate(10, 'nomor');
        $datadetailKelalaian = $bulan ? $this->DetailKelalaian->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgl_Kelalaian', 'desc')->findall() : $this->DetailKelalaian->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgl_Kelalaian', 'desc')->findall();
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $dataKelalaian,
            'tampildatadetail' => $datadetailKelalaian,
            'pager' => $this->Kelalaian->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'bulan' => $bulan,
            'tahun' => $tahun


        ];
        return view('Kelalaian/dataKelalaianperbulan', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $jumlah = $this->request->getPost('jumlah');
            $idKelalaian = $this->request->getPost('idkelalaian');



            // //koding hitung dan update data Kelalaian
            $ModelKelalaian = new ModelKelalian();
            $cekdata = $ModelKelalaian->find($idKelalaian);
            if ($cekdata) {
                $subtotal_Kelalaian = $cekdata['subtotal_kelalaian'];
                $idkaryawan = $cekdata['id_karyawan'];

                // penambahan point ulasan
                $jumlahakhir = intval($subtotal_Kelalaian) - intval($jumlah);


                $ModelKelalaian->update($idKelalaian, [
                    'subtotal_kelalaian' => $jumlahakhir,
                ]);

                //update data rekap
                $bulansekarang = date('Y-m');
                $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
                if ($cekrekap) {
                    $ModelRekapInformasiKaryawan->update($idrekap, [
                        'Potongan_informasi' => $jumlahakhir,
                    ]);
                }

                if ($jumlahakhir == 0) {
                    $ModelKelalaian->delete($idKelalaian);
                }
            }

            //hapus data detail
            $ModelDetailKelalaian = new ModelDetailKelalian();
            $ModelDetailKelalaian->delete($id);


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

        return view('kelalaian/formtambahkelalaian');
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