<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DapilDprRi extends Model
{
    protected $table = 'dapil_dpr_ri';

    public $timestamps = false;

    protected $fillable = [
        'pro_id',
        'pro_nama',
        'wilayah_prov_id',
        'dapil_id',
        'dapil_kode',
        'dapil_nama',
    ];
}
