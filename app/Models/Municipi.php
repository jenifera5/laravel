<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
    use HasFactory;

    protected $fillable = [];

public function provincia()
{
    return $this->belongsTo(Provincies::class, 'id_provincia');
}
public function cp_municipi()
{
    return $this->belongsTo(Cp ::class, 'cp_municipis_id');
}
public function direccions()
{
    return $this->hasMany(Direccion::class, 'direccion_id');
}

}
