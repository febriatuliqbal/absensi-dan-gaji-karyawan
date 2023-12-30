<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelJamKerja;
use App\Models\ModelRekapInformasiKaryawan;
use CodeIgniter\I18n\Time;
use CodeIgniter\Validation\Validation;
use DateTime;

class InputAbsensiIzinKaryawanApi extends ResourceController
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
        $tanggalSekarang = date('Y-m-d');
        $id_karyawan = $this->request->getVar("id_karyawan");
        $shift = $this->request->getVar("shift");
        $keterangan = $this->request->getVar("jam_masuk");
        $jam_masuk = $this->request->getVar("jam_masuk");
        $jam_pulang = $this->request->getVar("jam_pulang");
        $lokasi_masuk = $this->request->getVar("lokasi_masuk");
        $lokasi_pulang = $this->request->getVar("lokasi_pulang");
        $foto_masuk = $this->request->getVar("foto_masuk");
        $foto_kaluar = $this->request->getVar("foto_kaluar");
        $keterangan = $this->request->getVar("keterangan");
        $status = $this->request->getVar("status");


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
                'err_upload' => $validation->getError('id_absensi')
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
                'lokasi_masuk' => $lokasi_masuk,
                'foto_masuk' => $foto_masuk,
                'foto_kaluar' => $foto_kaluar,
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
                'lokasi_pulang' => $lokasi_pulang,
                'keterangan' => $keterangan,
                'status' => $status,
                'shift' => $shift

            ]);

            //koding hitung  data rekap karyawab
            $bulansekarang = date('Y-m');
            $idabsensi =  $id_karyawan . '-20' . date('ym', strtotime($bulansekarang));
            // $totaldata = $modelInputAbsensi->count();

            //mendapatan jumlah rekap absensi bulan ini
            $modelEstimasi = new ModelInputAbsensiKaryawan();
            $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
            $totaldataabsen = count($dataabsen);
            $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
            $totaldatterlambat = count($dataterlambat);
            $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
            $totaldatacepatpulang = count($dataacepatpulang);
            $datahadir = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->get()->getResult();
            $totaldatahadir = count($datahadir) - $totaldataabsen;


            //koding hitung  data rekap karyawab
            $bulansekarang = date('Y-m');
            $idrekap = sprintf('REK-') . $id_karyawan . date('dmy', strtotime($bulansekarang));
            $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
            $ModelRekapInformasiKaryawan->update($idrekap, [
                'Hadir_rekap_informasi' => $totaldatahadir,
                'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
                'Telat_rekap_informasi' => $totaldatterlambat,
                'Absen_rekap_informasi' => $totaldataabsen,
            ]);




            $response = [
                'status' => 201,
                'error' => "false",
                'massage' => "Data  Berhasil Disimpan",
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
        $shift = $this->request->getVar("shift");
        $keterangan = $this->request->getVar("jam_masuk");
        $jam_masuk = $this->request->getVar("jam_masuk");
        $jam_pulang = $this->request->getVar("jam_pulang");
        $lokasi_masuk = $this->request->getVar("lokasi_masuk");
        $lokasi_pulang = $this->request->getVar("lokasi_pulang");
        $foto_masuk = $this->request->getVar("foto_masuk");
        $foto_kaluar = $this->request->getVar("foto_kaluar");
        $keterangan = $this->request->getVar("keterangan");
        $status = $this->request->getVar("status");



        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $data = [
            'id_karyawan' => $id_karyawan,
            'lokasi_masuk' => $lokasi_masuk,
            'foto_masuk' => $foto_masuk,
            'foto_kaluar' => $foto_kaluar,
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang,
            'lokasi_pulang' => $lokasi_pulang,
            'keterangan' => $keterangan,
            'status' => $status,
            'shift' => $shift
        ];

        $data = $this->request->getRawInput();
        $modelInputAbsensi->update($id, $data);

        //rumus mencari data yang kan di update manual manggunakan php
        $modelInputAbsensi = new ModelInputAbsensiKaryawan();
        $cekdata = $modelInputAbsensi->find($id);

        if ($cekdata) {
            $jam_pulangkerja = $cekdata['jam_pulang'];
            $idkar = $cekdata['id_karyawan'];
            $shiftbaru = $cekdata['shift'];
            $statusbaru = $cekdata['status'];
        }

        //koding hitung  data rekap karyawab
        $bulansekarang = date('Y-m');
        $idabsensi =  $idkar . '-20' . date('ym', strtotime($bulansekarang));
        // $totaldata = $modelInputAbsensi->count();

        //mendapatan jumlah rekap absensi bulan ini
        $modelEstimasi = new ModelInputAbsensiKaryawan();
        $dataabsen = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Izin")->get()->getResult();
        $totaldataabsen = count($dataabsen);
        $dataterlambat = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Terlambat")->get()->getResult();
        $totaldatterlambat = count($dataterlambat);
        $dataacepatpulang = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->Like('status', "Cepat Pulang")->get()->getResult();
        $totaldatacepatpulang = count($dataacepatpulang);
        $datahadir = $modelEstimasi->tampildata()->Like('id_absensi', $idabsensi)->get()->getResult();
        $totaldatahadir = count($datahadir) - $totaldataabsen;

        //koding hitung  data rekap karyawab
        $bulansekarang = date('Y-m');
        $idrekap = sprintf('REK-') . $idkar . date('dmy', strtotime($bulansekarang));
        $ModelRekapInformasiKaryawan = new ModelRekapInformasiKaryawan();
        $ModelRekapInformasiKaryawan->update($idrekap, [
            'Hadir_rekap_informasi' => $totaldatahadir,
            'Pulangcepat_rekap_informasi' => $totaldatacepatpulang,
            'Telat_rekap_informasi' => $totaldatterlambat,
            'Absen_rekap_informasi' => $totaldataabsen,
        ]);


        $response = [
            'status' => 201,
            'error' => "False",
            'massage' => "Data Izin Berhasi Di Update",



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