<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cp extends Model
{
    use HasFactory;
    protected $table = 'cp_municipis';

    public function municipi()
    {
        return $this->belongsTo(Municipi::class,'id_municipi');
    }

}

