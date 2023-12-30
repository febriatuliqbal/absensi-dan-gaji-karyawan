<?php

namespace App\Controllers;

use App\Models\ModelDetailHutang;
use App\Models\ModelHutang;
use App\Models\ModelKaryawan;
use App\Models\ModelLokasiKantor;

class LokasiKantor extends BaseController
{
    public function __construct()
    {
        $this->ModelLokasi =  new ModelLokasiKantor();
    }

    public function index()
    {


        $ModelLokasi = new ModelLokasiKantor();
        $cekid = $ModelLokasi->find(1);


        if ($cekid) {
            $latitude = $cekid['latitude'];
            $longitude = $cekid['longitude'];

            $data = [

                'longitude' => $longitude,
                'latitude' => $latitude,

            ];

            return view('lokasikantor/viewlokasikantor', $data);
        } else {
            exit('DATA TIDAK DITEMUKAN');
        }
    }


    public function updatedata()
    {

        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');




        $this->ModelLokasi->update(1, [
            'latitude' => $latitude,
            'longitude' => $longitude,


        ]);

        $pesanSukses = [
            'sukses' => '<br><div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
                 Data Lokasi Berhasil Diupdate
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> '

        ];

        session()->setFlashdata($pesanSukses);
        return redirect()->to('LokasiKantor/index');
    }
}