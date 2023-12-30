<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{

    protected $table            = 'tb_pengguna';
    protected $primaryKey       = 'username_peng';

    protected $allowedFields    = ['username_peng', 'password_peng', 'peng_level'];

    public function tampildata()
    {
        return $this->table('tb_pengguna');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_karyawan')->orlike('username_peng', $cari);
    }
}