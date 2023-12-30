<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelInputAbsensiKaryawan;
use CodeIgniter\Validation\Validation;

class UploudFoto extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        //menampilkan 3 orang paling disiplin berdasarkan jumlah absen
        $data = $modelInputAbsensi->findAll();
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
        $modelMhs = new ModelInputAbsensiKaryawan();

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'foto_masuk' => [
                'rules' => 'uploaded[foto_masuk]|is_image[foto_masuk]|ext_in[foto_masuk,png,jpg,jpeg,gif]', //memastikan file yg di upload benar2 gambar
                'mime_in[foto_masuk,image/png,image/jpg,image/jpeg,image/gif]', //memastikan file yg di upload benar2 gambar
                'label' => 'File Image',
                'errors' => [
                    'uploaded' => "{field} Harus di uploud $nobp",
                    'is_image' => "{field} Harus di berupa gambar(png,jpg,jpeg,gif)",
                    'mime_in' => "{field} Harus di berupa mime gambar(png,jpg,jpeg,gif)"
                ]
            ]

        ]);

        if (!$valid) {

            $error_msg = [
                'err_upload' => $validation->getError('foto_masuk')
            ];

            $response = [
                'status' => 404,
                'error' => "True",
                'massage' => $error_msg,


            ];
            return $this->respond($response, 404);
        } else {

            // hapus data jika ada
            $cekdata = $modelMhs->find($nobp);
            if ($cekdata['foto_masuk'] != null || $cekdata['foto_masuk'] != "") {
                //untuk web bisa pakai di bawah aja, tapi karena ada data chace android makanha kita ubah sedikit
                // unlink('datagambar/' . $cekdata['foto_masuk']);

                $fotolama = $cekdata['foto_masuk']; //ambil nama lama file

                //update foto
                $img = $this->request->getFile('foto_masuk');
                if (!$img->hasMoved()) {
                    $img->move('datagambar', $nobp . '.' . $img->getExtension());
                }

                unlink('datagambar/' . $fotolama);

                $data = [
                    'foto_masuk' => $img->getName(),
                ];


                $modelMhs->update($nobp, $data);

                $response = [
                    'status' => 201,
                    'error' => "False",
                    'massage' => "Foto Berhasi Di Uploud",
                    'id_absensi' => "$nobp",


                ];
                return $this->respond($response, 201);
            } else {

                //update foto
                $img = $this->request->getFile('foto_masuk');
                if (!$img->hasMoved()) {
                    $img->move('datagambar', $nobp . '.' . $img->getExtension());
                }

                $data = [
                    'foto_masuk' => $img->getName(),
                ];

                $modelMhs->update($nobp, $data);

                $response = [
                    'status' => 201,
                    'error' => 201,
                    'massage' => "Foto Berhasi Di Uploud",
                    'id_absensi' => "$nobp",


                ];
                return $this->respond($response, 201);
            }
        }
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