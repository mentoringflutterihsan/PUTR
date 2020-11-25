<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desa extends Model
{
  
    public function kecamatan(){
        return $this->belongsTo(kecamatan::class);
    }
    public function pembangunans(){
        return $this->hasMany(pembangunan::class);
    }
}
