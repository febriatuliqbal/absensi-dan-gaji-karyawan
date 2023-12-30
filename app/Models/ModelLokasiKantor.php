<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLokasiKantor extends Model
{

    protected $table            = 'tb_lokasi_kantor';
    protected $primaryKey       = 'id_lokasi';

    protected $allowedFields    = ['latitude', 'longitude'];

    public function tampildata()
    {
        return $this->table('tb_lokasi_kantor');
    }
}