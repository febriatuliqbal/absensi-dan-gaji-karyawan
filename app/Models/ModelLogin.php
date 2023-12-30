<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLogin extends Model
{
    protected $table = 'tb_pengguna';
    public function ceklogin($username)
    {
        $query = $this->table($this->table)->getWhere(['username_peng' => $username]);
        return $query;
    }
}