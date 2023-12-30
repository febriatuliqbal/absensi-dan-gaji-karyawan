<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailHutang extends Model
{

    protected $table            = 'tb_detail_hutang';
    protected $primaryKey       = 'id_detail_hutang';

    protected $allowedFields    = ['id_hutang', 'tgl_hutang', 'userkaryawan_hutang', 'jumlah_hutang', 'ket_hutang'];

    public function tampildata()
    {
        return $this->table('tb_detail_hutang')->join('tb_karyawan', 'idkaryawan=userkaryawan_hutang');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_detail_hutang')->join('tb_karyawan', 'idkaryawan=userkaryawan_hutang')->orlike('ket_hutang', $cari)->orlike('nama_karyawan', $cari);
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_detail_hutang')->join('tb_karyawan', 'idkaryawan=userkaryawan_hutang')->where('MONTH(tgl_hutang)', $bulan)->where('YEAR(tgl_hutang)', $tahun);
    }
}