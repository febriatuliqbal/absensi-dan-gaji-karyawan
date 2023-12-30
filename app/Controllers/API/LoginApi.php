<?php

namespace App\Controllers\API;


use CodeIgniter\RESTful\ResourceController;

use App\Models\ModelLogin;
use App\Models\ModelKaryawan;
use App\Models\ModelRekapInformasiKaryawan;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;




class LoginApi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelLogin = new ModelLogin();
        $username = $this->request->getVar("username_peng");
        $passpengguna = $this->request->getVar("password_peng");

        $cekUser = $modelLogin->ceklogin($username);
        if (count($cekUser->getResultArray()) > 0) {

            $row = $cekUser->getRowArray();
            $pass_hash = $row['password_peng'];

            $string = json_encode($passpengguna);
            $passwordhash_sha = sha1($string);

            if ($passwordhash_sha == $pass_hash) {
                //varivikasi pasword dengan token
                $issudate_claim = time();
                $expire_time = $issudate_claim + 86400; //token nya hanya berlaku 1 hari/ 86400 detik, bisa disesuakan dengan kebutuhan

                $token = [
                    'iat' => $issudate_claim,
                    'exp' => $expire_time,

                ];

                //mendapatkan id karyawan 
                $modelkarywan = new ModelKaryawan();
                $cekidkar = $modelkarywan->cariid($username);
                if (count($cekidkar->getResultArray()) > 0) {
                    $rew = $cekidkar->getRowArray();
                    $idkaryyawan = $rew['idkaryawan'];


                    // //koding tambah data rekap karyawan jika belum ada
                    $tanggalSekarang = date('Y-m-d');
                    $bulansekarang = date('Y-m');
                    $idrekap = sprintf('REK-') . $idkaryyawan . date('dmy', strtotime($bulansekarang));
                    $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
                    $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
                    if ($cekrekap) {
                        //joka data rekap ada tidak melakukan apa2
                    } else {
                        //simpan data  rekap
                        $ModelRekapInformasiKaryawan->insert([
                            'id_rekap_informasi' => $idrekap,
                            'Bulan_rekap_informasi' => $tanggalSekarang,
                            'Potongan_informasi' => 0,
                            'id_user' => $idkaryyawan,
                            'Hadir_rekap_informasi' => 0,
                            'Absen_rekap_informasi' => 0,
                            'Telat_rekap_informasi' => 0,
                            'Pulangcepat_rekap_informasi' => 0,
                            'Hutang_informasi' => 0,
                            'Lembur_informasi' => 0,





                        ]);
                    }

                    //disini dengaja di masukan ke dalam agar yg belum terdaftark sbgai krjwan belum bisa login di aplikasi android sedangkan di web bisa
                    $token = JWT::encode($token, getenv("TOKEN_KEY"), 'HS256');
                    $output = [
                        'status' => 200,
                        'error' => 200,
                        'massage' => 'Login Berhasil',
                        'token' => $token,
                        'username' => $username,
                        'idkaryyawan' => $idkaryyawan,

                    ];

                    return $this->respond($output, 200);
                } else {
                    // $idkaryyawan = "TIDAK DITEMUKAN";
                    return $this->failNotFound("Maaf Username atau pasword anda masukan Salah");
                }

                // $token = JWT::encode($token, getenv("TOKEN_KEY"), 'HS256');
                // $output = [
                //     'status' => 200,
                //     'error' => 200,
                //     'massage' => 'Login Berhasil',
                //     'token' => $token,
                //     'username' => $username,
                //     'idkaryyawan' => $idkaryyawan,
                // ];
                // return $this->respond($output, 200);

            } else {

                return $this->failNotFound("Maaf Username atau pasword anda masukan Salah");
            }
        } else {

            return $this->failNotFound("Maaf Username atau pasword anda masukan Salah");
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}