<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desa extends Model
{
    use SoftDeletes;

    /**
     * Mass fillable field
     *
     * @var array
     */
    protected $fillable = [
        'nama_desa',
        'luas_wilayah',
        'kecamatan_id'
    ];

    /**
     * Relationship to `kecamatans` table
     *
     * @return mixed
     */
    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Relationship to `pembangunan` table
     *
     * @return mixed
     */
    public function pembangunans(){
        return $this->hasMany(Pembangunan::class);
    }
}
