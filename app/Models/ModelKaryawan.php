<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKaryawan extends Model
{

    protected $table            = 'tb_karyawan';
    protected $primaryKey       = 'idkaryawan';

    protected $allowedFields    = ['nama_karyawan', 'jabatan_karyawan', 'status_karyawan', 'gajipokok__karyawan', 'tmakan_karyawan', 'thadir_karyawan', 'alamat_karyawan', 'username_karyawan', 'foto_karyawan'];

    public function tampildata()
    {
        return $this->table('tb_karyawan');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_karyawan')->orlike('nama_karyawan', $cari)->orlike('username_karyawan', $cari);
    }


    public function cariid($cari)
    {
        return $this->table('tb_karyawan')->where('username_karyawan', $cari)->get();
    }
}