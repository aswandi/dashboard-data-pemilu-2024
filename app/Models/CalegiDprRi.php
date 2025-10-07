<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalegiDprRi extends Model
{
    protected $table = 'caleg_dpr_ri';

    protected $fillable = [
        'pro_id',
        'pro_nama',
        'dapil_id',
        'dapil_kode',
        'dapil_nama',
        'partai_id',
        'partai_politik',
        'caleg_id',
        'nama',
        'nomor_urut',
        'jenis_kelamin',
        'tempat_tinggal',
        'suara',
    ];

    public $timestamps = false;

    protected $casts = [
        'nomor_urut' => 'integer',
        'suara' => 'integer',
    ];
}
