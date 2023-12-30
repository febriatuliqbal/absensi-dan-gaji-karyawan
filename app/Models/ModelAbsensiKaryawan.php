<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAbsensiKaryawan extends Model
{

    protected $table            = 'rekap_absensi_karyawan';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['Nama', 'Foto', 'Hadir', 'Absen', 'Telat', 'Pulangcepat'];

    public function tampildata()
    {
        return $this->table('rekap_absensi_karyawan');
    }
}