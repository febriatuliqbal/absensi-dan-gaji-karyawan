<?php

namespace App\Controllers;

use App\Models\ModelDataUserUntukModal;
use App\Models\ModelKaryawan;
use App\Models\ModelUser;
use Config\Services;
use Kint\Parser\ToStringPlugin;

class User extends BaseController
{
    public function __construct()
    {
        $this->Pengguna =  new ModelUser();
    }

    public function index()
    {

        $model = new ModelUser();

        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_pengguna', $cari);
            redirect()->to('pengguna/index');
        } else {
            $cari = session()->get('cari_pengguna');
        }

        $totaldata = $cari ? $this->Pengguna->tampildata_cari($cari)->countAllResults() : $this->Pengguna->tampildata()->countAllResults();
        $datapengguna = $cari ? $this->Pengguna->tampildata_cari($cari)->paginate(10, 'nomor') : $this->Pengguna->tampildata()->paginate(10, 'nomor');
        $nohalaman = $this->request->getVar('page_nomor') ? $this->request->getVar('page_nomor') : 1;

        $data = [
            'tampildata' => $datapengguna,
            'pager' => $this->Pengguna->pager,
            'nohalaman' => $nohalaman,
            'totaldata' => $totaldata,
            'cari' => $cari

        ];
        return view('pengguna/viewpengguna', $data);
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');


            $Model = new ModelUser();

            $Model->delete($id);

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

        return view('pengguna/formtambahpengguna');
    }

    public function modalDataPelanggan()
    {
        if ($this->request->isAJAX()) {

            $json = [
                'data' => view('pengguna/modaldata')
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }

    public function listDataPengguna()
    {
        $request = Services::request();
        $datamodel = new ModelDataUserUntukModal($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            $satuan = ('Rp. ');
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $tombolpilih = "<button type=\"button\" class=\"btn  btn-sm btn-primary\" onclick=\"pilih('" . $list->username_peng . "')\"> <i class=\"bi bi-cursor-fill\"> Pilih</i> </button>";
                //isi tabel
                $row[] = $no;
                $row[] = $list->username_peng;
                $row[] = $list->peng_level;
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

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level = $this->request->getPost('level');

        $string = json_encode($password);
        $passwordhash_sha = sha1($string);



        // validasi
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'username' => [
                'rules' => 'required|is_unique[tb_pengguna.username_peng]',
                'label' => 'Username',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} Sudah Digunakan, Coba Dengan Username Lain'
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
            return redirect()->to('user/tambah');
        } else {


            $this->Pengguna->insert([
                'username_peng' => $username,
                'password_peng' => $passwordhash_sha,
                'peng_level' => $level
            ]);

            $pesanSukses = [
                'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $username . ' Berhasil Disimpan
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];

            session()->setFlashdata($pesanSukses);
            return redirect()->to('User/index');
        }
    }

    public function updatedata()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level = $this->request->getPost('level');
        // $passwordhasku = password_hash($password, PASSWORD_DEFAULT);


        if (!$password) {


            $this->Pengguna->update($username, [
                'peng_level' => $level,

            ]);

            $pesanSukses = [
                'sukses' => '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $username . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];
        } else {

            $string = json_encode($password);
            $passwordhash_sha = sha1($string);


            $this->Pengguna->update($username, [
                'password_peng' => $passwordhash_sha,
                'peng_level' => $level,

            ]);

            $pesanSukses = [
                'sukses' => '<div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data ' . $username . ' Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

            ];
        }
        session()->setFlashdata($pesanSukses);
        return redirect()->to('User/index');
    }

    function edit($id)
    {
        $ModelUser = new ModelUser();
        $cekid = $ModelUser->find($id);


        if ($cekid) {

            $data = [
                'id' => $id,
                'peng_level' => $cekid['peng_level'],

            ];

            return view('pengguna/formeditpengguna', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }
}