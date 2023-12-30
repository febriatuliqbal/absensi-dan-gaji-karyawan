<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailLembur extends Model
{

    protected $table            = 'tb_detail_lembur';
    protected $primaryKey       = 'id_detail';

    protected $allowedFields    = ['id_lembur', 'idkaryawan', 'tgllembur', 'lama_lembur', 'ket'];

    public function tampildata()
    {
        return $this->table('tb_detail_lembur')->join('tb_karyawan', 'tb_karyawan.idkaryawan=tb_detail_lembur.idkaryawan');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_detail_lembur')->join('tb_karyawan',  'tb_karyawan.idkaryawan=tb_detail_lembur.idkaryawan')->orlike('ket', $cari)->orlike('nama_karyawan', $cari);
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_detail_lembur')->join('tb_karyawan',  'tb_karyawan.idkaryawan=tb_detail_lembur.idkaryawan')->where('MONTH(tgllembur)', $bulan)->where('YEAR(tgllembur)', $tahun);
    }
}