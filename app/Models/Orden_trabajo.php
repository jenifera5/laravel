<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Orden_trabajo extends Model
{
    use HasFactory;
    protected $fillable=['descripcion','client_id','horas','date_open','date_close', 'operario_id', 'direccion_id'];

    // INdiquem que el nom del model no coincideix amb el nom plural de la taula
    protected $table = 'ordenes_trabajo';

    public function operario()
    {
        return $this->belongsTo(User::class, 'operario_id');
    }
    // public function material()
    // {
    //     return $this->belongsToMany(Material::class, 'order_materials','ordenes_trabajo_id','material_id');
    // }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function albaran()
    {
        return $this->belongsTo(Albaran::class, 'ordenes_trabajo_id');
    }
    public function direccio()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }
}

