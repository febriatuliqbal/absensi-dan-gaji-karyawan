<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRekapInformasiKaryawan extends Model
{

    protected $table            = 'tb_informasi_karyawan';
    protected $primaryKey       = 'id_rekap_informasi';

    protected $allowedFields    = ['id_rekap_informasi', 'id_user', 'Bulan_rekap_informasi', 'Hadir_rekap_informasi', 'Absen_rekap_informasi', 'Telat_rekap_informasi', 'Pulangcepat_rekap_informasi', 'Potongan_informasi', 'Hutang_informasi', 'Lembur_informasi'];

    public function tampildata()
    {
        return $this->table('tb_informasi_karyawan')->join('tb_karyawan', 'idkaryawan=id_user');
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_informasi_karyawan')->join('tb_karyawan', 'idkaryawan=id_user')->where('MONTH(Bulan_rekap_informasi)', $bulan)->where('YEAR(Bulan_rekap_informasi)', $tahun);
    }
}