<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelJamKerja;
use App\Models\ModelRekapInformasiKaryawan;
use CodeIgniter\I18n\Time;
use CodeIgniter\Validation\Validation;
use DateTime;

class InputAbsensiKaryawanApi extends ResourceController
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
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $data = $modelInputAbsensi->orLike('id_absensi', $cari)->orLike('id_absensi', $cari)->get()->getResult();

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
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $id_absensi = $this->request->getPost("id_absensi");
        $id_karyawan = $this->request->getPost("id_karyawan");
        $tanggalSekarang = date('Y-m-d');
        $jam_masuk = $this->request->getPost("jam_masuk");
        $lokasi_masuk = $this->request->getPost("lokasi_masuk");
        $keterangan = $this->request->getPost("keterangan");
        $shift = $this->request->getPost("shift");


        //membuat kode transaksi lanjut terus 1-2-3-4

        // $tanggalSekarang = date('Y-m-d');
        // $Modeltaransaksi = new ModelInputAbsensiKaryawan();

        // $hasil = $Modeltaransaksi->nofaktur($tanggalSekarang)->getRowArray();
        // $data = $hasil['nofaktur'];

        // $noUrutTerakhir = substr($data, -4);
        // //nomor urut ditambah 1
        // $nomorUrutSelanjutnya = intval($noUrutTerakhir) + 1;
        // //membuat format nomor transaksi berikutnya
        // $noFaktur = sprintf('TRK-') . date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nomorUrutSelanjutnya);


        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'id_absensi' => [
                'rules' => 'is_unique[absensi_karyawan.id_absensi]',
                'label' => 'Anda Sudah Absen Sebelumnya',
                'errors' => [
                    'is_unique' => "{field}"
                ]
            ]

        ]);

        if (!$valid) {

            $error_msg = [
                'Anda Sudah Absen Sebelumnya'
            ];

            $response = [
                'status' => 404,
                'error' => "True",
                'massage' => $error_msg,
                'id_absensi' => "$id_absensi",
            ];
            return $this->respond($response, 404);
        } else {

            $modelInputAbsensi->insert([
                'id_absensi' => $id_absensi,
                'id_karyawan' => $id_karyawan,
                'tgl_absensi' => $tanggalSekarang,
                'shift' => $shift,
                'jam_masuk' => $jam_masuk,
                'lokasi_masuk' => $lokasi_masuk,
                'keterangan' => $keterangan,
                'foto_kaluar' => 'fotokosong.png',

            ]);

            //rumus mencari data yang kan di update manual manggunakan php
            $modelInputAbsensi = new ModelInputAbsensiKaryawan();
            $cekdata = $modelInputAbsensi->find($id_absensi);

            if ($cekdata) {
                $jammasuk = $cekdata['jam_masuk'];
                $shift = $cekdata['shift'];
                $idkar = $cekdata['id_karyawan'];


                $modeljamkerja = new ModelJamKerja();
                $cekjamkerja = $modeljamkerja->find($shift);

                if ($cekjamkerja) {
                    $masukjamkerja = $cekjamkerja['jammasuk'];
                }
            }

            //rumus perhitungan jarak waktu


            $jamseharusnyamasuk = new Time($masukjamkerja);
            $waktumasuk = new Time($jammasuk);
            $interval = $jamseharusnyamasuk->diff($waktumasuk);
            $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

            if ($interval->invert == 1) {
                $seconds = -$seconds;
            } else {
                $seconds = $seconds;
            }



            if ($seconds < 600) {
                $status = "Tepat Waktu";
                $jumlahterlambat = 0;
            } else {
                $status = "Terlambat";
                $jumlahterlambat = 1;
            }


            //jaki ada menggunakan beberapa rumus di php maka kita update 2 kali datanya

            $modelInputAbsensi->update($id_absensi, [
                'status' => $status,
            ]);

            //koding hitung  data rekap karyawab
            $bulansekarang = date('Y-m');
            $idabsensibaru =  $idkar . '-20' . date('ym', strtotime($bulansekarang));
            // $totaldata = $modelInputAbsensi->count();

            //mendapatan jumlah absensi bulan ini
            $modelEstimasi = new ModelInputAbsensiKaryawan();
            $data = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensibaru)->Like('status', "Terlambat")->get()->getResult();
            $totaldata = count($data);






            // //koding hitung  data rekap karyawab
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $id_karyawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
            if ($cekrekap) {

                $Hadir_rekap_informasi = $cekrekap['Hadir_rekap_informasi'];

                $jumlahakhirinformasihadir = intval($Hadir_rekap_informasi) + 1;
                $ModelRekapInformasiKaryawan->update($idrekap, [
                    'Telat_rekap_informasi' => $totaldata,
                    'Hadir_rekap_informasi' => $jumlahakhirinformasihadir,
                ]);
            } else {
                //tidak melakukan apaapa
            }


            $response = [
                'status' => 201,
                'error' => "false",
                'massage' => "Data Absensi Berhasil Disimpan  $id_absensi",
                'id_absensi' => "$id_absensi",


            ];


            return $this->respond($response, 201);
        }
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


        $id_karyawan = $this->request->getVar("id_karyawan");
        $tanggalSekarang = date('Y-m-d');
        $jam_masuk = $this->request->getVar("jam_masuk");
        $lokasi_masuk = $this->request->getVar("lokasi_masuk");
        $foto_masuk = $this->request->getVar("foto_masuk");
        $keterangan = $this->request->getVar("keterangan");
        $shift = $this->request->getPost("shift");


        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $data = [
            'id_karyawan' => $id_karyawan,
            'tgl_absensi' => $tanggalSekarang,
            'jam_masuk' => $jam_masuk,
            'tgl_absensi' => $tanggalSekarang,
            'shift' => $shift,
            'jam_masuk' => $jam_masuk,
            'lokasi_masuk' => $lokasi_masuk,
            'keterangan' => $keterangan,



        ];


        $data = $this->request->getRawInput();
        $modelInputAbsensi->update($id, $data);


        //rumus mencari data yang kan di update manual manggunakan php
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $cekdata = $modelInputAbsensi->find($id);

        if ($cekdata) {
            $jammasuk = $cekdata['jam_masuk'];
            $idkar = $cekdata['id_karyawan'];
            $shift = $cekdata['shift'];


            $modeljamkerja = new ModelJamKerja();
            $cekjamkerja = $modeljamkerja->find($shift);

            if ($cekjamkerja) {
                $masukjamkerja = $cekjamkerja['jammasuk'];
            }
        }

        //rumus perhitungan jarak waktu


        $jamseharusnyamasuk = new Time($masukjamkerja);
        $waktumasuk = new Time($jammasuk);
        $interval = $jamseharusnyamasuk->diff($waktumasuk);
        $seconds = $interval->days * 24 * 60 * 60 + $interval->h * 60 * 60 + $interval->i * 60 + $interval->s;

        if ($interval->invert == 1) {
            $seconds = -$seconds;
        } else {
            $seconds = $seconds;
        }

        if ($seconds < 600) {
            $status = "Tepat Waktu";
            $jumlahterlambat = 0;
        } else {
            $status = "Terlambat";
            $jumlahterlambat = 1;
        }


        //jaki ada menggunakan beberapa rumus di php maka kita update 2 kali datanya

        $modelInputAbsensi->update($id, [
            'status' => $status,
        ]);

        //koding hitung  data rekap karyawab
        $bulansekarang = date('Y-m');
        $idabsensibaru =  $idkar . '-20' . date('ym', strtotime($bulansekarang));
        // $totaldata = $modelInputAbsensi->count();

        //mendapatan jumlah absensi bulan ini
        $modelEstimasi = new ModelInputAbsensiKaryawan();
        $data = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensibaru)->Like('status', "Terlambat")->get()->getResult();
        $totaldata = count($data);




        //koding hitung  data rekap karyawab
        $bulansekarang = date('Y-m');
        $idrekap = sprintf('REK-') . $idkar . date('dmy', strtotime($bulansekarang));
        $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
        $ModelRekapInformasiKaryawan->update($idrekap, [
            'Telat_rekap_informasi' => $totaldata,
        ]);


        // // //koding hitung  data rekap karyawab
        // $bulansekarang = date('Y-m');
        // $idrekap = sprintf('REK-') . $idkar . date('dmy', strtotime($bulansekarang));
        // $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
        // $cekrekap = $ModelRekapInformasiKaryawan->find($idrekap);
        // if ($cekrekap) {
        //     $Telat_rekap_informasi = $cekrekap['Telat_rekap_informasi'];
        //     if ($Telat_rekap_informasi == "0") {
        //         $jumlahakhirinformasi = intval($Telat_rekap_informasi) + intval($jumlahterlambat);
        //     } else {
        //         $jumlahakhirinformasi = intval($Telat_rekap_informasi) - 1 + intval($jumlahterlambat);
        //     }

        //     $ModelRekapInformasiKaryawan->update($idrekap, [
        //         'Telat_rekap_informasi' => $jumlahakhirinformasi,
        //     ]);
        // } else {
        //     //tidak melakukan apaapa

        //     $jumlahakhirinformasi = 505;
        //     $ModelRekapInformasiKaryawan->update($idrekap, [
        //         'Telat_rekap_informasi' => $jumlahakhirinformasi,
        //     ]);
        // }





        $response = [
            'status' => 201,
            'error' => "False",
            'massage' => "Data Berhasi Diupdate",



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
        // $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        // $cekdata = $modelInputAbsensi->find($nobp);
        // if ($cekdata) {
        //     $modelInputAbsensi->delete($nobp);
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