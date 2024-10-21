<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveidor extends Model
{
    use HasFactory;

    protected $fillable=['name','nif','direccio','telefon','telefon2','email','contacte','enCurs','diaCobrament','observacions','cp_id','provincia_id',];



















}
