<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Material extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['codigo', 'description', 'stock', 'numero_serie', 'proveidor_id', 'marca_id', 'familia_id', 'preciocoste', 'pvp', 'encurso', 'observaciones'];

    public function proveidors()
    {
        return $this->belongsToMany(Proveidor::class, 'proveidors');
    }

    public function albarans()
    {
        return $this->belongsTo(Albaran::class, 'albarans');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images/materials')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        if (env('RESIZE_IMAGE') === true) {

            $this->addMediaConversion('resized-image')
                ->width(env('IMAGE_WIDTH', 300))
                ->height(env('IMAGE_HEIGHT', 300));
        }
    }
}
