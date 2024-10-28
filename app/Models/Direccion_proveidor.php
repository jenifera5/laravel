<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion_proveidor extends Model
{
    use HasFactory;
    protected $fillable=["carrer", "numero", "pis", "porta", "observacions", "cp_id", "provincia_id", "municipi_id", 'proveidor_id'];

      // INdiquem que el nom del model no coincideix amb el nom plural de la taula
      protected $table = 'direccions_proveidors';
    public function cps()
{
    return $this->hasOne(Cp::class);
}

    public function  proveidors()
    {
        return $this->hasone(Proveidor::class);
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
