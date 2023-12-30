<?php

namespace App\Controllers;

use App\Models\ModelDetailHutang;
use App\Models\ModelDetailKelalian;
use App\Models\ModelInputAbsensiKaryawan;
use App\Models\ModelRekapInformasiKaryawan;

class Home extends BaseController
{
    public function index()
    {
        $bulanini = date('m');
        $tahunini = date('Y');
        $DetailHutang = new ModelDetailHutang();
        $jumlahpinjaman = $DetailHutang->cari_berdasarkan_bln_thn($bulanini, $tahunini)->countAllResults();
        $datapinjaman = $DetailHutang->cari_berdasarkan_bln_thn($bulanini, $tahunini)->get();

        $totalSubtotal = 0;
        foreach ($datapinjaman->getResultArray() as $total) :
            $totalSubtotal += intval($total['jumlah_hutang']);
        endforeach;

        $DetailKelalaian = new ModelDetailKelalian();
        $jumlahkelalaian = $DetailKelalaian->cari_berdasarkan_bln_thn($bulanini, $tahunini)->countAllResults();
        $datakelalaian = $DetailKelalaian->cari_berdasarkan_bln_thn($bulanini, $tahunini)->get();

        $totalSubtotal2 = 0;
        foreach ($datakelalaian->getResultArray() as $total) :
            $totalSubtotal2 += intval($total['jumlah_kelalain']);
        endforeach;

        $bulansekarang = date('Y-m');
        $idrekap =  date('dmy', strtotime($bulansekarang));
        $modelEstimasi = new ModelRekapInformasiKaryawan();
        $data = $modelEstimasi->tampildata()->orLike('id_rekap_informasi', $idrekap)->OrderBy('Hadir_rekap_informasi', 'desc')->OrderBy('Telat_rekap_informasi', 'asc')->paginate(3);



        $data = [
            'tampildata' => $data,
            'jumlahpinjaman' => $jumlahpinjaman,
            'totalpinajam' => $totalSubtotal,
            'jumlahkelalaian' => $jumlahkelalaian,
            'totallalai' => $totalSubtotal2,
        ];

        return view('beranda/beranda', $data);
    }


    public function detailabsensi()
    {
        if ($this->request->isAJAX()) {

            // $id = $this->request->getPost('id');
            // $model = new ModelDetailGaji();
            // $datadetailgaji = $model->tampildata()->OrderBy('nama_karyawan', 'asc')->getWhere(['idgaji' => $id]);

            // $totalSubtotal = 0;
            // foreach ($datadetailgaji->getResultArray() as $total) :
            //     $totalSubtotal += intval($total['total_gaji']);
            // endforeach;
            $tanggalhariini = date('Y-m-d');
            $model = new ModelInputAbsensiKaryawan();
            $datadetailgaji = $model->tampildata()->orLike('tgl_absensi', $tanggalhariini)->get();


            $data = [
                'datadetailabsensi' => $datadetailgaji,
                // 'total' => $totalSubtotal
            ];

            $json = [
                'data' => view('absensi/dataabsensi', $data),
                // 'totalSubtotal' => "Rp." . number_format($totalSubtotal, 0, ",", "."),
            ];
            echo json_encode($json);
        } else {
            exit('MAAF TIDAK BISA DI PANGGIL');
        }
    }
}