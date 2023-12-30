<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailGaji extends Model
{

    protected $table            = 'tb_detail_gaji';
    protected $primaryKey       = 'id_detail_gaji';

    protected $allowedFields    = ['id_detail_gaji', 'idgaji', 'idkar', 'idrekap', 'bonus', 'total_gaji',  'tgldetailgaji', 'gajipokoksaatini', 'tunj_makansaatini', 'tunj_hadirsaatini', 'gajiditerima', 'status_gaji'];

    public function tampildata()
    {
        return $this->table('tb_detail_gaji')->join('tb_karyawan', 'idkaryawan=idkar')->join('tb_informasi_karyawan', 'id_rekap_informasi=idrekap');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_detail_gaji')->join('tb_karyawan', 'idkaryawan=idkar')->join('tb_informasi_karyawan', 'id_rekap_informasi=idrekap')->orlike('nama_karyawan', $cari);
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('tb_detail_gaji')->join('tb_karyawan', 'idkaryawan=idkar')->join('tb_informasi_karyawan', 'id_rekap_informasi=idrekap')->where('MONTH(tgldetailgaji)', $bulan)->where('YEAR(tgldetailgaji)', $tahun);
    }
}