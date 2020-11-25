<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    use SoftDeletes;

    /**
     * Mass fillable field
     *
     * @var array
     */
    protected $fillable = [
        'nama_kecamatan',
        'luas_wilayah'
    ];

    /**
     * Relationship to `desas` table
     *
     * @return mixed
     */
    public function desa(){
        return $this->hasMany(Desa::class);
    }
}
