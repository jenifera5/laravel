<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincies extends Model
{
    use HasFactory;

    public function direccions()
    {
        return $this->hasMany(Direccion::class, 'direccion_id');
    }
    public function minicipis()
    {
        return $this->hasMany(Municipi::class, 'municipis_id');
    }
}
