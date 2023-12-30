<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelInputAbsensiKaryawan extends Model
{

    protected $table            = 'absensi_karyawan';
    protected $primaryKey       = 'id_absensi';

    protected $allowedFields    = ['id_absensi', 'id_karyawan', 'tgl_absensi', 'shift', 'jam_masuk', 'jam_pulang', 'lokasi_masuk', 'lokasi_pulang', 'foto_masuk', 'foto_kaluar', 'keterangan', 'keterangan', 'status'];

    public function tampildata()
    {
        return $this->table('absensi_karyawan')->join('tb_karyawan', 'idkaryawan=id_karyawan')->join('tb_jamkerja', 'id=shift');
    }

    public function tampildata_cari($cari)
    {
        return $this->table('absensi_karyawan')->join('tb_karyawan', 'idkaryawan=id_karyawan')->join('tb_jamkerja', 'id=shift')->orlike('nama_karyawan', $cari);
    }

    public function cariberdasarkanId_Status($status)
    {
        return $this->table('absensi_karyawan')->orlike('id_absensi', $status);
    }

    public function cari_berdasarkan_bln_thn($bulan, $tahun)
    {
        return $this->table('absensi_karyawan')->join('tb_karyawan', 'idkaryawan=id_karyawan')->join('tb_jamkerja', 'id=shift')->where('MONTH(tgl_absensi)', $bulan)->where('YEAR(tgl_absensi)', $tahun);
    }

    public function dataperhari($tanggal)
    {
        return $this->table('absensi_karyawan')->join('tb_karyawan', 'idkaryawan=id_karyawan')->join('tb_jamkerja', 'id=shift')->where('tgl_absensi', $tanggal);
    }
}