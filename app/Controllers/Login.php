<?php

namespace App\Controllers;

use App\Models\ModelDataUserUntukModal;
use App\Models\ModelKaryawan;
use App\Models\ModelLogin;
use App\Models\ModelUser;
use Config\Services;
use Kint\Parser\ToStringPlugin;

class Login extends BaseController
{
    public function __construct()
    {
        $this->Login =  new ModelLogin();
    }

    public function index()
    {

        return view('login/login');
    }


    public function cekuser()
    {
        $iduser = $this->request->getPost('iduser');
        $pass = $this->request->getPost('pass');

        // validasi
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'iduser' => [
                'rules' => 'required',
                'label' => 'ID USER',
                'errors' => [
                    'required' => '{field} TIDAK BOLEH KOSONG',

                ]
            ],
            'pass' => [
                'rules' => 'required',
                'label' => 'PASSWORD',
                'errors' => [
                    'required' => '{field} TIDAK BOLEH KOSONG',


                ]
            ],
        ]);
        if (!$valid) {
            $sessErorr = [
                'errIdUser' => $validation->getError('iduser'),
                'errPassword' => $validation->getError('pass'),

            ];

            session()->setFlashdata($sessErorr);
            return redirect()->to('/login/index');
        } else {

            $modelLogin = new ModelUser();

            $cekUserLogin = $modelLogin->find($iduser);

            if ($cekUserLogin == null) {

                $gagal = [
                    'sesion' => 'Username/Pasword Anda Salah',

                ];

                session()->setFlashdata($gagal);
                return redirect()->to('/login/index');
            } else {

                $pass_hash = $cekUserLogin['password_peng'];
                $string = json_encode($pass);
                $passwordhash_sha = sha1($string);

                if ($passwordhash_sha == $pass_hash) {
                    $idlevel = $cekUserLogin['peng_level'];
                    $username_peng = $cekUserLogin['username_peng'];

                    if ($idlevel == "3") {
                        $gagal = [
                            'sesion' => 'Username/Pasword Anda Salah',

                        ];

                        session()->setFlashdata($gagal);
                        return redirect()->to('/login/index');
                    } else {
                        $simpan_sesion = [
                            'iduser' => $iduser,
                            'namauser' => $username_peng,
                            'idlevel' => $idlevel,
                        ];

                        session()->set($simpan_sesion);

                        return redirect()->to('/Home/index');
                    }
                } else {

                    $gagal = [
                        'sesion' => 'Username/Pasword Anda Salah',

                    ];

                    session()->setFlashdata($gagal);
                    return redirect()->to('/login/index');
                }
            }
        }
    }

    public function keluar()
    {
        session()->destroy();
        return redirect()->to('/Login/index');
    }
}