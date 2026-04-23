<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoPublicacion extends Model
{
    public $timestamps = false;

    protected $table = 'fotos_publicaciones';

    protected $fillable = ['publicacion_id', 'url'];

    protected $casts = ['created_at' => 'datetime'];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}