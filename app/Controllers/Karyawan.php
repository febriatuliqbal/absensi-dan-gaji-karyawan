<?php

namespace App\Controllers;

use App\Models\ModelDataKaryawanUntukModal;
use App\Models\ModelKaryawan;
use Config\Services;

class Karyawan extends BaseController
{
    public function __construct()
    {
        $this->karyawan =  new ModelKaryawan();
    }

    public function index()
    {
        $model = new ModelKaryawan();

        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_karyawan', $cari);
            redirect()->to('karyawan/index');
        } else {
            $cari = session()->get('cari_karyawan');
        }

        $totaldata = $cari ? $this->karyawan->tampildata_cari($cari)->countAllResults() : $this->karyawan->tampildata()->countAllResults();
        $datakaryawan = $cari ? $this->karyawan->tampildata_cari($cari)->paginate(10, 'nomor') : $this->karyawan->tampildata()->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datakaryawan,
            'pager' => $this->karyawan->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('karyawan/viewkaryawan', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $ModelKaryawan = new ModelKaryawan();

            $ModelKaryawan->delete($id);

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

        return view('karyawan/formtambahkaryawan');
    }

    public function modaldatakaryawan()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('karyawan/modaldata')
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    public function listDataKaryawan()
    {
        $request = Services::request();
        $datamodel = new ModelDataKaryawanUntukModal($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $tombolpilih = "<button type=\"button\" class=\"btn  btn-sm btn-primary\" onclick=\"pilih('" . $list->idkaryawan . "','" . $list->nama_karyawan . "','" . $list->jabatan_karyawan . "')\"> <i class=\"bi bi-cursor-fill\"> Pilih</i> </button>";
                //isi tabel
                $row[] = $no;
                $row[] = $list->nama_karyawan;
                $row[] = $list->jabatan_karyawan;
                $row[] = $tombolpilih;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function simpandata()
    {

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

            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'Gambar',
                'errors' => [
                    'mime_in' => 'Format File {field} Salah, Pastikan Formatnya (png,jpg,jpeg)'
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
            return redirect()->to('Karyawan/tambah');
        } else {

            $gambar = $_FILES['gambar']['name'];

            if ($gambar != NULL) {
                $namafilegambar = $nama;
                $filegambar = $this->request->getFile('gambar');
                $filegambar->move('uploud', $namafilegambar . '.' . $filegambar->getExtension());

                $patGambar = $filegambar->getName();
            } else {
                $patGambar = '';
            }
            $this->karyawan->insert([
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
                 Data ' . $nama . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('Karyawan/index');
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