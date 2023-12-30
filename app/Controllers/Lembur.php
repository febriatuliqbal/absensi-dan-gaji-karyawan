<?php

namespace App\Controllers;


use App\Models\ModelDetailLembur;
use App\Models\ModelKaryawan;

use App\Models\ModelLembur;
use App\Models\ModelRekapInformasiKaryawan;

class Lembur extends BaseController
{
    public function __construct()
    {
        $this->ModelDetail =  new ModelDetailLembur();
        $this->Kelalaian =  new ModelLembur();
    }

    public function index()
    {


        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('caro_lembur', $cari);
            redirect()->to('Kelalaian/index');
        } else {
            $cari = session()->get('caro_lembur');
        }

        $totaldata = $cari ? $this->ModelDetail->tampildata_cari($cari)->countAllResults() : $this->ModelDetail->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->ModelDetail->tampildata_cari($cari)->OrderBy('id_detail', 'desc')->paginate(10, 'nomor') : $this->ModelDetail->tampildata()->OrderBy('id_detail', 'desc')->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->ModelDetail->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('lembur/viewlembur', $data);
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
            redirect()->to('Lembur/dataperbulan');
        } else {
            $bulan = $bulanini;
            $tahun = $tahunini;
        }

        $totaldata = $bulan ? $this->ModelDetail->cari_berdasarkan_bln_thn($bulan, $tahun)->countAllResults() : $this->ModelDetail->cari_berdasarkan_bln_thn($bulanini, $tahun)->countAllResults();
        $dataKelalaian = $bulan ? $this->Kelalaian->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('bulanlembur', 'desc')->paginate(10, 'nomor') : $this->Kelalaian->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('bulanlembur', 'desc')->paginate(10, 'nomor');
        $dataModelDetail = $bulan ? $this->ModelDetail->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgllembur', 'desc')->findall() : $this->ModelDetail->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgllembur', 'desc')->findall();
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $dataKelalaian,
            'tampildatadetail' => $dataModelDetail,
            'pager' => $this->Kelalaian->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'bulan' => $bulan,
            'tahun' => $tahun


        ];
        return view('Lembur/datalemburperbulan', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $jumlah = $this->request->getPost('jumlah');
            $idKelalaian = $this->request->getPost('idkelalaian');



            // //koding hitung dan update data Kelalaian
            $ModelKelalaian = new ModelLembur();
            $cekdata = $ModelKelalaian->find($idKelalaian);
            if ($cekdata) {
                $subtotal_Kelalaian = $cekdata['subtotallembur'];
                $idkaryawan = $cekdata['idkaryawan'];

                // penambahan point ulasan
                $jumlahakhir = intval($subtotal_Kelalaian) - intval($jumlah);


                $ModelKelalaian->update($idKelalaian, [
                    'subtotallembur' => $jumlahakhir,
                ]);

                //update data rekap
                $bulansekarang = date('Y-m');
                $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
                if ($cekrekap) {
                    $ModelRekapInformasiKaryawan->update($idrekap, [
                        'Lembur_informasi' => $jumlahakhir,
                    ]);
                }

                if ($jumlahakhir == 0) {
                    $ModelKelalaian->delete($idKelalaian);
                }
            }

            //hapus data detail
            $ModelModelDetail = new ModelDetailLembur();
            $ModelModelDetail->delete($id);


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

        return view('lembur/formtambahlembur');
    }

    public function simpandata()
    {

        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $lamalembur = $this->request->getPost('lamalembur');
        $keterangan = $this->request->getPost('keterangan');
        $tanggalSekarang = date('Y-m-d');
        $bulansekarang = date('Y-m');

        //membuat kode transaksi        
        $idlembur = sprintf('LEM-') . $idkaryawan . date('dmy', strtotime($bulansekarang));


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
            return redirect()->to('Lembur/tambah');
        } else {

            // //koding hitung dan update data Kelalaian
            $ModelKelalaian = new ModelLembur();
            $cekdata = $ModelKelalaian->find($idlembur);
            if ($cekdata) {
                $subtotallembur = $cekdata['subtotallembur'];

                // penambahan Kelalaian
                $jumlahakhir = intval($subtotallembur) + intval($lamalembur);

                $ModelKelalaian->update($idlembur, [
                    'subtotallembur' => $jumlahakhir,
                ]);
            } else {

                //simpan data  Kelalaian
                $this->Kelalaian->insert([
                    'id_lembur' => $idlembur,
                    'bulanlembur' => $tanggalSekarang,
                    'subtotallembur' => $lamalembur,
                    'idkaryawan' => $idkaryawan,

                ]);
            }


            // //koding hitung dan update data rekap karyawab
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekrekap) {
                $Lembur_informasi = $cekrekap['Lembur_informasi'];
                $jumlahakhirinformasi = intval($Lembur_informasi) + intval($lamalembur);
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Lembur_informasi' => $jumlahakhirinformasi,
                ]);
            } else {

                //simpan data  rekap
                $ModelRekapInformasiKaryawan->insert([
                    'id_rekap_informasi' => $idrekap,
                    'Bulan_rekap_informasi' => $tanggalSekarang,
                    'Potongan_informasi' => 0,
                    'id_user' => $idkaryawan,
                    'Hadir_rekap_informasi' => 0,
                    'Absen_rekap_informasi' => 0,
                    'Telat_rekap_informasi' => 0,
                    'Pulangcepat_rekap_informasi' => 0,
                    'Hutang_informasi' => 0,
                    'Lembur_informasi' => $lamalembur,




                ]);
            }




            //simpan data detail Kelalaian
            $this->ModelDetail->insert([
                'id_lembur' => $idlembur,
                'tgllembur' => $tanggalSekarang,
                'idkaryawan' => $idkaryawan,
                'lama_lembur' => $lamalembur,
                'ket' => $keterangan


            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data  ' . $nama . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Lembur/index');
        }
    }

    public function updatedata()
    {
        $iddetail = $this->request->getPost('iddetail');
        $idlembur = $this->request->getPost('idkelalaian');
        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $lamalembur = $this->request->getPost('lamalembur');
        $lamalemburawal = $this->request->getPost('lamalemburawal');
        $keterangan = $this->request->getPost('keterangan');

        //update data  master Kelalaian
        $ModelKelalaian = new ModelLembur();
        $cekdata = $ModelKelalaian->find($idlembur);

        if ($cekdata) {
            $subtotal_Kelalaian = $cekdata['subtotallembur'];

            // penambahan Kelalaian
            $jumlahakhir = intval($subtotal_Kelalaian) - intval($lamalemburawal)  + intval($lamalembur);

            $ModelKelalaian->update($idlembur, [
                'subtotallembur' => $jumlahakhir,

            ]);

            //update data rekap
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekdata = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekdata) {
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Lembur_informasi' => $jumlahakhir,
                ]);
            }

            //update data  detail Kelalaian

            $this->ModelDetail->update($iddetail, [
                'lama_lembur' => $lamalembur,
                'ket' => $keterangan

            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $nama . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Lembur/index');
        }
    }

    function edit($id)
    {
        $ModelModelDetail = new ModelDetailLembur();
        $Modelkarywan = new ModelKaryawan();
        $cekid = $ModelModelDetail->find($id);


        if ($cekid) {
            $idkaryawan = $cekid['idkaryawan'];
            $cekkaryawan = $Modelkarywan->find($idkaryawan);
            $namakaryawan = $cekkaryawan['nama_karyawan'];

            $data = [

                'id' => $id,
                'idkaryawan' => $idkaryawan,
                'namakaryawan' => $namakaryawan,
                'tgllembur' => $cekid['tgllembur'],
                'id_lembur' => $cekid['id_lembur'],
                'lama_lembur' => $cekid['lama_lembur'],
                'ket' => $cekid['ket'],

            ];

            return view('lembur/formeditlembur', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }
}