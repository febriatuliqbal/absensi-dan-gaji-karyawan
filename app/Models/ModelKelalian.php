<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelalian extends Model
{

    protected $table            = 'tb_kelalaian';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['id', 'tgl', 'subtotal_kelalaian', 'id_karyawan'];


    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_kelalaian')->join('tb_karyawan', 'idkaryawan=id_karyawan')->where('MONTH(tgl)', $bulan)->where('YEAR(tgl)', $tahun);
    }
}