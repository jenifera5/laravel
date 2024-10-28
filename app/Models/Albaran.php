<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Albaran extends Model
{
    use HasFactory;

    protected $fillable=['ordenes_trabajo_id','titulo','description','material_id','horas','descuentos_id','precio_id','iva'];

    public function ordenes_trabajo()
    {
        return $this->belongsToMany(Orden_trabajo::class,'ordenes_trabajo');
    }
    public function materials()
    {
        return $this->belongsTo(Material::class, 'materials');
    }
}
