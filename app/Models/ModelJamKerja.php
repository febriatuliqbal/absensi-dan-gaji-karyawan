<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJamKerja extends Model
{

    protected $table            = 'tb_jamkerja';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['nama_jamkerja', 'jammasuk', 'jamkeluar'];

    public function tampildata()
    {
        return $this->table('tb_jamkerja');
    }
    public function tampildata_cari($cari)
    {
        return $this->table('tb_jamkerja')->orlike('nama_jamkerja', $cari);
    }
}