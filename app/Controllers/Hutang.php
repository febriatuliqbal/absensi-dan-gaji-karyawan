<?php

namespace App\Controllers;

use App\Models\ModelDetailHutang;
use App\Models\ModelHutang;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelKaryawan;
use App\Models\ModelRekapInformasiKaryawan;

class Hutang extends BaseController
{
    public function __construct()
    {
        $this->DetailHutang =  new ModelDetailHutang();
        $this->Hutang =  new ModelHutang();
    }

    public function index()
    {


        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_hutang', $cari);
            redirect()->to('Hutang/index');
        } else {
            $cari = session()->get('cari_hutang');
        }

        $totaldata = $cari ? $this->DetailHutang->tampildata_cari($cari)->countAllResults() : $this->DetailHutang->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->DetailHutang->tampildata_cari($cari)->OrderBy('id_detail_hutang', 'desc')->paginate(10, 'nomor') : $this->DetailHutang->tampildata()->OrderBy('id_detail_hutang', 'desc')->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->DetailHutang->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('hutang/viewhutang', $data);
    }

    public function datahutangperbulan()
    {


        $tombolcari = $this->request->getPost('tombolcari');
        $bulanini = date('m');
        $tahunini = date('Y');

        if (isset($tombolcari)) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');
            session()->set('bulan', $bulan);
            redirect()->to('Hutang/datahutangperbulan');
        } else {
            $bulan = $bulanini;
            $tahun = $tahunini;
        }

        $totaldata = $bulan ? $this->DetailHutang->cari_berdasarkan_bln_thn($bulan, $tahun)->countAllResults() : $this->DetailHutang->cari_berdasarkan_bln_thn($bulanini, $tahun)->countAllResults();
        $datahutang = $bulan ? $this->Hutang->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgl', 'desc')->paginate(10, 'nomor') : $this->Hutang->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgl', 'desc')->paginate(10, 'nomor');
        $datadetailhutang = $bulan ? $this->DetailHutang->cari_berdasarkan_bln_thn($bulan, $tahun)->OrderBy('tgl_hutang', 'desc')->findall() : $this->DetailHutang->cari_berdasarkan_bln_thn($bulanini, $tahunini)->OrderBy('tgl_hutang', 'desc')->findall();
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datahutang,
            'tampildatadetail' => $datadetailhutang,
            'pager' => $this->Hutang->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'bulan' => $bulan,
            'tahun' => $tahun


        ];
        return view('hutang/viewhutangperbulan', $data);
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $jumlah = $this->request->getPost('jumlah');
            $idhutang = $this->request->getPost('idhutang');



            // //koding hitung dan update data hutang
            $ModelHutang = new ModelHutang();
            $cekdata = $ModelHutang->find($idhutang);
            if ($cekdata) {
                $subtotal_hutang = $cekdata['subtotal_hutang'];
                $idkaryawan = $cekdata['id_karyawan_hutang'];


                // penambahan point ulasan
                $jumlahakhir = intval($subtotal_hutang) - intval($jumlah);


                $ModelHutang->update($idhutang, [
                    'subtotal_hutang' => $jumlahakhir,
                ]);

                //update data rekap
                $bulansekarang = date('Y-m');
                $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
                $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
                if ($cekrekap) {
                    $ModelRekapInformasiKaryawan->update($idrekap, [
                        'Hutang_informasi' => $jumlahakhir,
                    ]);
                }



                if ($jumlahakhir == 0) {
                    $ModelHutang->delete($idhutang);
                }
            }

            //hapus data detail
            $ModelDetailHutang = new ModelDetailHutang();
            $ModelDetailHutang->delete($id);


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

        return view('hutang/formtambahhutang');
    }

    public function simpandata()
    {

        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jumlahhutang = $this->request->getPost('jumlahhutang');
        $keterangan = $this->request->getPost('keterangan');
        $tanggalSekarang = date('Y-m-d');
        $bulansekarang = date('Y-m');


        //membuat kode transaksi        
        $idhutang = sprintf('HUT-') . $idkaryawan . date('dmy', strtotime($bulansekarang));



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
            return redirect()->to('Hutang/tambah');
        } else {

            // //koding hitung dan update data hutang
            $ModelHutang = new ModelHutang();
            $cekdata = $ModelHutang->find($idhutang);
            if ($cekdata) {
                $subtotal_hutang = $cekdata['subtotal_hutang'];

                // penambahan hutang
                $jumlahakhir = intval($subtotal_hutang) + intval($jumlahhutang);

                $ModelHutang->update($idhutang, [
                    'subtotal_hutang' => $jumlahakhir,
                ]);
            } else {
                //simpan data  hutang
                $this->Hutang->insert([
                    'id' => $idhutang,
                    'tgl' => $tanggalSekarang,
                    'subtotal_hutang' => $jumlahhutang,
                    'id_karyawan_hutang' => $idkaryawan,

                ]);
            }

            // //koding hitung dan update data rekap karyawab

            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekrekap) {
                $rekap_hutang = $cekrekap['Hutang_informasi'];
                $jumlahakhirinformasi = intval($rekap_hutang) + intval($jumlahhutang);
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Hutang_informasi' => $jumlahakhirinformasi,
                ]);
            } else {

                //simpan data  rekap
                $ModelRekapInformasiKaryawan->insert([
                    'id_rekap_informasi' => $idrekap,
                    'Bulan_rekap_informasi' => $tanggalSekarang,
                    'Hutang_informasi' => $jumlahhutang,
                    'id_user' => $idkaryawan,
                    'Hadir_rekap_informasi' => 0,
                    'Absen_rekap_informasi' => 0,
                    'Telat_rekap_informasi' => 0,
                    'Pulangcepat_rekap_informasi' => 0,
                    'Potongan_informasi' => 0,




                ]);
            }

            //simpan data detail hutang
            $this->DetailHutang->insert([
                'id_hutang' => $idhutang,
                'tgl_hutang' => $tanggalSekarang,
                'userkaryawan_hutang' => $idkaryawan,
                'jumlah_hutang' => $jumlahhutang,
                'ket_hutang' => $keterangan

            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $nama . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Hutang/index');
        }
    }

    public function updatedata()
    {
        $id = $this->request->getPost('id_det_hutang');
        $id_hutang = $this->request->getPost('id_hutang');
        $hutangawal = $this->request->getPost('hutangawal');
        $idkaryawan = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jumlahhutang = $this->request->getPost('jumlahhutang');
        $keterangan = $this->request->getPost('keterangan');

        //update data  master hutang
        $ModelHutang = new ModelHutang();
        $cekdata = $ModelHutang->find($id_hutang);

        if ($cekdata) {
            $subtotal_hutang = $cekdata['subtotal_hutang'];

            // penambahan hutang
            $jumlahakhir = intval($subtotal_hutang) - intval($hutangawal)  + intval($jumlahhutang);

            //update data master hutang
            $ModelHutang->update($id_hutang, [
                'subtotal_hutang' => $jumlahakhir,

            ]);

            //update data rekap
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $idkaryawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekrekap) {
                $rekap_hutang = $cekrekap['Hutang_informasi'];

                $jumlahakhirinformasi = intval($rekap_hutang) - intval($hutangawal)  + intval($jumlahhutang);

                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Hutang_informasi' => $jumlahakhirinformasi,
                ]);
            }

            //update data  detail hutang

            $this->DetailHutang->update($id, [
                'jumlah_hutang' => $jumlahhutang,
                'jumlah_hutang' => $jumlahhutang,
                'ket_hutang' => $keterangan

            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $nama . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Hutang/index');
        }
    }

    function edit($id)
    {
        $ModelDetailHutang = new ModelDetailHutang();
        $ModelKaryawan = new ModelKaryawan();
        $cekid = $ModelDetailHutang->find($id);


        if ($cekid) {
            $idkaryawan = $cekid['userkaryawan_hutang'];
            $cekkaryawan = $ModelKaryawan->find($idkaryawan);
            $namakaryawan = $cekkaryawan['nama_karyawan'];

            $data = [

                'id' => $id,
                'idkaryawan' => $idkaryawan,
                'namakaryawan' => $namakaryawan,
                'tgl_hutang' => $cekid['tgl_hutang'],
                'id_hutang' => $cekid['id_hutang'],
                'jumlah_hutang' => $cekid['jumlah_hutang'],
                'ket_hutang' => $cekid['ket_hutang'],

            ];

            return view('hutang/formedithutang', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }
}