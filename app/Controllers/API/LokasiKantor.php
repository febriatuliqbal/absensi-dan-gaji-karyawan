<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelLokasiKantor;

use CodeIgniter\Validation\Validation;

class LokasiKantor extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $ModelLokasiKantor = new ModelLokasiKantor();
        //menampilkan 3 orang paling disiplin berdasarkan jumlah absen
        $data = $ModelLokasiKantor->findAll();
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
        $ModelLokasiKantor = new ModelLokasiKantor();
        $data = $ModelLokasiKantor->orLike('id_lokasi', $cari)->orLike('id_lokasi', $cari)->get()->getResult();

        if (count($data) > 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'massage' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else if (count($data) == 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'massage' => '',
                'totaldata' => count($data),
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