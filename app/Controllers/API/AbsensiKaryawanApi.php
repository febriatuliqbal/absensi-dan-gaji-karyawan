<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelAbsensiKaryawan;
use App\Models\ModelRekapInformasiKaryawan;
use CodeIgniter\Validation\Validation;

class AbsensiKaryawanApi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {

        $bulansekarang = date('Y-m');
        $idrekap =  date('dmy', strtotime($bulansekarang));

        $modelEstimasi = new ModelRekapInformasiKaryawan();
        $data = $modelEstimasi->tampildata()->orLike('id_rekap_informasi', $idrekap)->OrderBy('Hadir_rekap_informasi', 'desc')->OrderBy('Telat_rekap_informasi', 'asc')->paginate(3);

        $response = [
            'status' => 200,
            'error' => "false",
            'massage' => '',
            'totaldata' => count($data),
            'data' => $data,

        ];
        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
        // $modelMhs = new ModelAbsensiKaryawan();
        // $data = $modelMhs->orLike('Nama', $cari)->orLike('Nama', $cari)->get()->getResult();

        // if (count($data) > 1) {
        //     $response = [
        //         'status' => 200,
        //         'error' => "false",
        //         'massage' => '',
        //         'totaldata' => count($data),
        //         'data' => $data,
        //     ];
        //     return $this->respond($response, 200);
        // } else if (count($data) == 1) {
        //     $response = [
        //         'status' => 200,
        //         'error' => "false",
        //         'massage' => '',
        //         'totaldata' => count($data),
        //         'data' => $data,
        //     ];
        //     return $this->respond($response, 200);
        // } else {
        //     return $this->failNotFound("Maaf data $cari tidak dapat ditemukan");
        // }
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
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($nobp = null)
    {
    }
}