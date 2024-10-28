<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;
    protected $table = 'idiomes';

    public function client(){
        return $this->hasMany(Client::class, 'Idiomes_id');
    }
}
