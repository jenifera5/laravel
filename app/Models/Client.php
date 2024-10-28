<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ["id", "name", "surname1", "surname2", "nif",  "telefon", "telefon2", "email","idioma_id" ];

public function idioma()
{
    return $this->belongsTo(Idioma::class, 'idioma_id');
}
public function direccions()
{
    return $this->hasMany(Direccion::class, 'client_id');
}

}
