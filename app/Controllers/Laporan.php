<?php

namespace App\Controllers;

use App\Models\ModelDetailGaji;
use App\Models\ModelDetailHutang;
use App\Models\ModelDetailKelalian;
use App\Models\ModelDetailLembur;
use App\Models\ModelGaji;
use App\Models\ModelHutang;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelKaryawan;
use App\Models\ModelKelalian;
use App\Models\ModelLembur;
use App\Models\ModelRekapInformasiKaryawan;
use Kint\Parser\ToStringPlugin;

class Laporan extends BaseController
{

    public function index()
    {
    }

    public function cetakslipgaji($id)
    {
        $model = new ModelDetailGaji();
        $datadetailgaji = $model->tampildata()->find($id);

        if ($datadetailgaji != null) {

            $data = [
                'id' => $id,
                'nama_karyawan' => $datadetailgaji['nama_karyawan'],
                'jabatan_karyawan' => $datadetailgaji['jabatan_karyawan'],
                'gajipokoksaatini' => $datadetailgaji['gajipokoksaatini'],
                'tunj_makansaatini' => $datadetailgaji['tunj_makansaatini'],
                'tunj_hadirsaatini' => $datadetailgaji['tunj_hadirsaatini'],
                'Lembur_informasi' => $datadetailgaji['Lembur_informasi'],
                'Absen_rekap_informasi' => $datadetailgaji['Absen_rekap_informasi'],
                'Absen_rekap_informasi' => $datadetailgaji['Absen_rekap_informasi'],
                'Telat_rekap_informasi' => $datadetailgaji['Telat_rekap_informasi'],
                'Pulangcepat_rekap_informasi' => $datadetailgaji['Pulangcepat_rekap_informasi'],
                'Potongan_informasi' => $datadetailgaji['Potongan_informasi'],
                'bonus' => $datadetailgaji['bonus'],
                'total_gaji' => $datadetailgaji['total_gaji'],
                'Hutang_informasi' => $datadetailgaji['Hutang_informasi'],
                'gajiditerima' => $datadetailgaji['gajiditerima'],
                'tgldetailgaji' => $datadetailgaji['tgldetailgaji'],
                'Hadir_rekap_informasi' => $datadetailgaji['Hadir_rekap_informasi'],



            ];



            return view('laporan/slipgajikaryawan', $data);
        }
    }

    public function laporandatakaryawan()
    {
        $ModelKaryawan = new ModelKaryawan();
        $datalaporan = $ModelKaryawan->findAll();

        $data = [
            'datalaporan' => $datalaporan,
        ];
        return view('laporan/cetaklaporankaryawan', $data);
    }

    public function laporanabsensikaryawan()
    {

        return view('laporan/laporanabsensikaryawan');
    }


    public function cetaklaporanabsensiperhari()
    {


        $tanggal = $this->request->getPost('tanggal');
        $Modeldata = new ModelInputAbsensiKaryawan();


        $datalaporan = $Modeldata->tampildata()->where('tgl_absensi', $tanggal)->get();
        $data = [
            'datalaporan' => $datalaporan,
            'tanggal' => $tanggal,
        ];
        return view('laporan/cetaklaporanabsensiperhari', $data);
    }


    public function cetakrekapkaryawanperbulanperkaryawan()
    {


        $bulan = $this->request->getPost('bulan2');
        $tahun = $this->request->getPost('tahun2');
        $tahunstr =  intval($tahun);

        $modelEstimasi = new ModelRekapInformasiKaryawan();
        $idrekap =  sprintf('01') . $bulan . substr($tahunstr, -2);
        $cekrekap = $modelEstimasi->tampildata()->orLike('id_rekap_informasi', $idrekap)->get();
        if ($cekrekap) {
            $data = [
                'datalaporan' => $cekrekap,
                'bulan2' => $bulan,
                'tahun2' => $tahun,

            ];
            return view('laporan/cetakrekapabsensikaryawan', $data);
        } else {
            $pesan = [
                'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

            ];
            session()->setFlashdata($pesan);
            return redirect()->to('Laporan/laporanabsensikaryawan');
        }
    }

    public function cetaklaporankaryawanperbulanperkaryawan()
    {


        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $idkar = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jabatan = $this->request->getPost('jabatan');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'username' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporanabsensikaryawan');
        } else {
            $modelEstimasi = new ModelRekapInformasiKaryawan();
            $idrekap = sprintf('REK-') . $idkar . sprintf('01') . $bulan . substr($tahunstr, -2);
            $cekrekap = $modelEstimasi->find($idrekap);
            if ($cekrekap) {
                $Modeldata = new ModelInputAbsensiKaryawan();
                $datalaporan = $Modeldata->cari_berdasarkan_bln_thn($bulan, $tahun)->where('id_karyawan', $idkar)->get();
                $data = [
                    'datalaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'idrekap' => $idrekap,
                    'Hadir_rekap_informasi' => $cekrekap['Hadir_rekap_informasi'],
                    'Absen_rekap_informasi' => $cekrekap['Absen_rekap_informasi'],
                    'Telat_rekap_informasi' => $cekrekap['Telat_rekap_informasi'],
                    'Pulangcepat_rekap_informasi' => $cekrekap['Pulangcepat_rekap_informasi'],
                ];
                return view('laporan/cetaklaporanabsensikaryawanperbulan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporanabsensikaryawan');
            }
        }
    }

    public function laporanhutangkaryawan()
    {

        return view('laporan/laporanhutangkaryawan');
    }

    public function cetaklaporanhutangkaryawanperbulanperkaryawan()
    {


        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $idkar = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jabatan = $this->request->getPost('jabatan');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'username' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporanhutangkaryawan');
        } else {

            $Modeldatadetail = new ModelDetailHutang();
            $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->where('userkaryawan_hutang', $idkar)->get();
            $totalSubtotal = 0;


            if ($datalaporan) {

                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['jumlah_hutang']);
                endforeach;

                $data = [

                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'totalSubtotal' => $totalSubtotal,

                ];
                return view('laporan/cetaklaporanhutangkaryawanperbulanperkaryawan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporanhutangkaryawan');
            }
        }
    }

    public function cetaklaporanhutangkaryawanperbulan()
    {


        $bulan = $this->request->getPost('bulan2');
        $tahun = $this->request->getPost('tahun2');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'tahun2' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporanhutangkaryawan');
        } else {

            $modeldata = new ModelHutang();
            $cekhutang = $modeldata->cari_berdasarkan_bln_thn($bulan, $tahun)->get();


            if ($cekhutang) {
                $Modeldatadetail = new ModelDetailHutang();
                $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->get();
                $totalSubtotal = 0;
                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['jumlah_hutang']);
                endforeach;

                $data = [
                    'datalaporan' => $cekhutang,
                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'totalSubtotal' => $totalSubtotal,

                ];
                return view('laporan/cetaklaporanhutangkaryawanperbulan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporanhutangkaryawan');
            }
        }
    }

    public function laporankalalaiankaryawan()
    {

        return view('laporan/laporankalalaiankaryawan');
    }

    public function cetaklaporankalalaianperbulanperkaryawan()
    {


        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $idkar = $this->request->getPost('username');
        $nama = $this->request->getPost('nama');
        $jabatan = $this->request->getPost('jabatan');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'username' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporankalalaiankaryawan');
        } else {

            $Modeldatadetail = new ModelDetailKelalian();
            $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->where('idkaryawan_kelalain', $idkar)->get();
            $totalSubtotal = 0;


            if ($datalaporan) {

                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['jumlah_kelalain']);
                endforeach;

                $data = [

                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'totalSubtotal' => $totalSubtotal,

                ];
                return view('laporan/cetaklaporankalalaianperbulanperkaryawan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporankalalaiankaryawan');
            }
        }
    }


    public function cetaklaporankalalaiankaryawanperbulan()
    {


        $bulan = $this->request->getPost('bulan2');
        $tahun = $this->request->getPost('tahun2');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'tahun2' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporankalalaiankaryawan');
        } else {

            $modeldata = new ModelKelalian();
            $cekhutang = $modeldata->cari_berdasarkan_bln_thn($bulan, $tahun)->get();


            if ($cekhutang) {
                $Modeldatadetail = new ModelDetailKelalian();
                $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->get();
                $totalSubtotal = 0;
                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['jumlah_kelalain']);
                endforeach;

                $data = [
                    'datalaporan' => $cekhutang,
                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'totalSubtotal' => $totalSubtotal,
                ];
                return view('laporan/cetaklaporankalalaiankaryawanperbulan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporankalalaiankaryawan');
            }
        }
    }

    public function laporangajikaryawan()
    {

        return view('laporan/laporangajikaryawan');
    }

    public function cetaklaporangajikaryawanperbulan()
    {


        $bulan = $this->request->getPost('bulan2');
        $tahun = $this->request->getPost('tahun2');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'tahun2' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporangajikaryawan');
        } else {

            $modeldata = new ModelGaji();
            $cekhutang = $modeldata->cari_berdasarkan_bln_thn($bulan, $tahun)->get();
            if ($cekhutang) {
                $Modeldatadetail = new ModelDetailGaji();
                $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->get();
                $totalSubtotal = 0;
                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['total_gaji']);
                endforeach;

                $data = [
                    'datalaporan' => $cekhutang,
                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'totalSubtotal' => $totalSubtotal,

                ];
                return view('laporan/cetaklaporangajikaryawanperbulan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporangajikaryawan');
            }
        }
    }


    public function laporanlemburkaryawan()
    {

        return view('laporan/laporanlemburkaryawan');
    }

    public function cetaklaporanlemburkaryawanperbulan()
    {


        $bulan = $this->request->getPost('bulan2');
        $tahun = $this->request->getPost('tahun2');
        $tahunstr =  intval($tahun);


        $validation = \Config\Services::validation();

        $valid = $this->validate([

            'tahun2' => [
                'rules' => 'required',
                'label' => 'Nama Karyawan',
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
            return redirect()->to('Laporan/laporankalalaiankaryawan');
        } else {

            $modeldata = new ModelLembur();
            $cekhutang = $modeldata->cari_berdasarkan_bln_thn($bulan, $tahun)->get();


            if ($cekhutang) {
                $Modeldatadetail = new ModelDetailLembur();
                $datalaporan = $Modeldatadetail->cari_berdasarkan_bln_thn($bulan, $tahun)->get();
                $totalSubtotal = 0;
                foreach ($datalaporan->getResultArray() as $total) :
                    $totalSubtotal += intval($total['lama_lembur']);
                endforeach;

                $data = [
                    'datalaporan' => $cekhutang,
                    'datadetaillaporan' => $datalaporan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'totalSubtotal' => $totalSubtotal,
                ];
                return view('laporan/cetaklaporanlemburkaryawanperbulan', $data);
            } else {
                $pesan = [
                    'error' => '
                 <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                ' . 'Data Tidak Ditemukan' . '
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> '

                ];
                session()->setFlashdata($pesan);
                return redirect()->to('Laporan/laporankalalaiankaryawan');
            }
        }
    }
}