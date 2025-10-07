<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $fillable = [
        'kode', 'nama', 'tipe', 'parent_id', 'idkel', 'id_prov', 'id_kota', 'id_kec',
        'id_wilayah_desa', 'kel', 'kec', 'kabkot', 'prov', 'iddesa', 'kdprov', 'nmprov',
        'kdkab', 'kdkec', 'kddesa', 'klas', 'kota_desa', 'tps', 'jml_dpt',
        'jml_laki_laki', 'jml_perempuan'
    ];

    protected $casts = [
        'tps' => 'integer',
        'jml_dpt' => 'integer',
        'jml_laki_laki' => 'integer',
        'jml_perempuan' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function scopeProvinsi($query)
    {
        return $query->where('tipe', 'provinsi');
    }

    public function scopeKabupaten($query)
    {
        return $query->where('tipe', 'kabupaten');
    }

    public function scopeKecamatan($query)
    {
        return $query->where('tipe', 'kecamatan');
    }

    public function scopeKelurahan($query)
    {
        return $query->where('tipe', 'kelurahan');
    }
}
