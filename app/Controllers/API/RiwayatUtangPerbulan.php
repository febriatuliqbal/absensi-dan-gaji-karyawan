<?php

namespace App\Controllers\API;

use App\Models\ModelDetailHutang;
use App\Models\ModelHutang;
use App\Models\ModelInputAbsensiKaryawan;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelRekapInformasiKaryawan;
use CodeIgniter\Validation\Validation;

class RiwayatUtangPerbulan extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // $modelEstimasi = new ModelInputAbsensiKaryawan();
        // //menampilkan 3 orang paling disiplin berdasarkan jumlah absen
        // $data = $modelEstimasi->findAll();
        // $response = [
        //     'status' => 200,
        //     'error' => "false",
        //     'massage' => '',
        //     'totaldata' => count($data),
        //     'data' => $data,

        // ];
        // return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
        $ModelDetailHutang = new ModelDetailHutang();
        $data = $ModelDetailHutang->orLike('id_hutang', $cari)->OrderBy('tgl_hutang', 'desc')->get()->getResult();
        $hutang = array_column($data, 'jumlah_hutang');
        $totalhutang = array_sum($hutang);

        if (count($data) > 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'massage' => '',
                'totaldata' => $totalhutang,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else if (count($data) == 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'massage' => '',
                'totaldata' => $totalhutang,
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            return $this->failNotFound("Maaf data $cari tidak dapat ditemukan");
        }
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
        // $modelEstimasi = new ModelRekapInformasiKaryawan();
        // $nobp = $this->request->getPost("mhsnobp");
        // $nama = $this->request->getPost("mhsnama");
        // $alamat = $this->request->getPost("mhsalamat");
        // $prodi = $this->request->getPost("prodinama");
        // $tgllahir = $this->request->getPost("mhstgllhr");

        // $validation = \Config\Services::validation();
        // $valid = $this->validate([
        //     'mhsnobp' => [
        //         'rules' => 'is_unique[mahasiswa.mhsnobp]',
        //         'label' => 'Nomor Induk Mahasiswa',
        //         'errors' => [
        //             'is_unique' => "{field} Sudah Ada"
        //         ]
        //     ]

        // ]);

        // if (!$valid) {

        //     $response = [
        //         'status' => 404,
        //         'error' => true,
        //         'massage' => $validation->getError('mhsnobp'),


        //     ];
        //     return $this->respond($response, 404);
        // } else {

        //     $modelEstimasi->insert([

        //         'mhsnobp' => $nobp,
        //         'mhsnama' => $nama,
        //         'mhsalamat' => $alamat,
        //         'prodinama' => $prodi,
        //         'mhstgllhr' => $tgllahir,
        //     ]);

        //     $response = [
        //         'status' => 201,
        //         'error' => false,
        //         'massage' => 'Data Mahasiswa Berhasil DI simpan',


        //     ];


        //     return $this->respond($response, 201);
        // }
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
    public function update($nobp = null)
    {
        // $modelEstimasi = new ModelRekapInformasiKaryawan();
        // $data = [
        //     'mhsnama' => $this->request->getVar("mhsnama"),
        //     'mhsalamat' => $this->request->getVar("mhsalamat"),
        //     'prodinama' => $this->request->getVar("prodinama"),
        //     'mhstgllhr' => $this->request->getVar("mhstgllhr"),
        // ];
        // $data = $this->request->getRawInput();
        // $modelEstimasi->update($nobp, $data);
        // $response = [
        //     'status' => 200,
        //     'error' => null,
        //     'massage' => "Data Dengan Nomor BP: $nobp Berhasil Diupdate",
        // ];
        // return $this->respondUpdated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($nobp = null)
    {
        // $modelEstimasi = new ModelRekapInformasiKaryawan();
        // $cekdata = $modelEstimasi->find($nobp);
        // if ($cekdata) {
        //     $modelEstimasi->delete($nobp);
        //     $response = [
        //         'status' => 200,
        //         'error' => false,
        //         'massage' => 'Data Mahasiswa Berhasil DiHapus',
        //     ];
        //     return $this->respondDeleted($response);
        // } else {
        //     return $this->failNotFound("Maaf Data Gagal Dihapus");
        // }
    }
}