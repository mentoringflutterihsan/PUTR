<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kecamatan extends Model
{
    
    public function desa(){
        return $this->hasMany(desa::class);
    }
}
