<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailKelalian extends Model
{

    protected $table            = 'tb_detail_kelalaian';
    protected $primaryKey       = 'id_detail_kelalaian';

    protected $allowedFields    = ['id_kelalaian', 'tgl_kelalaian', 'idkaryawan_kelalain', 'kerugian', 'jumlah_kelalain', 'ket_kelalaian'];

    public function tampildata()
    {
        return $this->table('tb_detail_kelalaian')->join('tb_karyawan', 'idkaryawan=idkaryawan_kelalain');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_detail_kelalaian')->join('tb_karyawan', 'idkaryawan=idkaryawan_kelalain')->orlike('ket_kelalaian', $cari)->orlike('nama_karyawan', $cari);
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_detail_kelalaian')->join('tb_karyawan', 'idkaryawan=idkaryawan_kelalain')->where('MONTH(tgl_kelalaian)', $bulan)->where('YEAR(tgl_kelalaian)', $tahun);
    }
}