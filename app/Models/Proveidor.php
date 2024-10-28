<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveidor extends Model
{
    use HasFactory;
    protected $fillable=['id','name','nif','telefon','telefon2','email','contacte','encurs','diacobrament','observacions'];


    public function direccions_proveidors()
{
    return $this->hasMany(Direccion_proveidor::class, 'proveidor_id');
}


}
