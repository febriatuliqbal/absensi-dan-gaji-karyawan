<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGaji extends Model
{

    protected $table            = 'tb_gaji';
    protected $primaryKey       = 'id_gaji';

    protected $allowedFields    = ['id_gaji', 'tgl_gaji', 'total_pengeluarangaji'];


    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_gaji')->where('MONTH(tgl_gaji)', $bulan)->where('YEAR(tgl_gaji)', $tahun);
    }
}