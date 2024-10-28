<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = ["carrer", "numero", "pis", "porta", "observacions", "cp_id", "provincia_id", "municipi_id", "client_id"];


public function cps()
{
    return $this->hasOne(Cp::class);
}

public function clients()
{
    return $this->hasone(Client::class);
}
public function provincies()
{
    return $this->hasOne(Provincies::class, 'provincia_id');
}
public function municipis()
{
    return $this->hasOne(Municipi::class, 'municipi_id');
}

}

