<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHutang extends Model
{

    protected $table            = 'tb_hutang';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['id', 'tgl', 'subtotal_hutang', 'id_karyawan_hutang'];


    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_hutang')->join('tb_karyawan', 'idkaryawan=id_karyawan_hutang')->where('MONTH(tgl)', $bulan)->where('YEAR(tgl)', $tahun);
    }
}