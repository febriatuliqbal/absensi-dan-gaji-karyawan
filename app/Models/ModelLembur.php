<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLembur extends Model
{

    protected $table            = 'tb_lembur';
    protected $primaryKey       = 'id_lembur';

    protected $allowedFields    = ['id_lembur', 'idkaryawan', 'bulanlembur', 'subtotallembur'];


    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_lembur')->join('tb_karyawan', 'tb_karyawan.idkaryawan=tb_lembur.idkaryawan')->where('MONTH(bulanlembur)', $bulan)->where('YEAR(bulanlembur)', $tahun);
    }
}