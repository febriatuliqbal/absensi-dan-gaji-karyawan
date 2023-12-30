<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelUser;
use CodeIgniter\Validation\Validation;

class GantiPasswordApi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        echo ('hai');
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
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
    public function update($username = null)
    {

        $password_peng = $this->request->getPost('password_peng');
        $data = [
            'password_peng' => $password_peng,
        ];
        $ModelUser = new ModelUser();
        $data = $this->request->getRawInput();
        $ModelUser->update($username, $data);

        $cekdata = $ModelUser->find($username);

        if ($cekdata) {
            $password_penglama = $cekdata['password_peng'];
        }

        $string = json_encode($password_penglama);
        $passwordhash_sha = sha1($string);

        $ModelUser->update($username, [
            'password_peng' => $passwordhash_sha,

        ]);

        $response = [
            'status' => 201,
            'error' => "False",
            'massage' => "Password Berhasi DiGanti $passwordhash_sha $username",
            'id_absensi' => "$username",


        ];
        return $this->respond($response, 201);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($nobp = null)
    {
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $cekdata = $modelInputAbsensi->find($nobp);
        if ($cekdata) {
            $modelInputAbsensi->delete($nobp);
            $response = [
                'status' => 200,
                'error' => "false",
                'massage' => 'Data Mahasiswa Berhasil DiHapus',
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Maaf Data Gagal Dihapus");
        }
    }
}