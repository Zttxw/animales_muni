<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table = 'comentarios';

    protected $fillable = [
        'publicacion_id', 'usuario_id', 'contenido',
        'estado', 'moderado_por', 'motivo_moderacion',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function moderadoPor()
    {
        return $this->belongsTo(Usuario::class, 'moderado_por');
    }

    public function scopeVisible($query)
    {
        return $query->where('estado', 'VISIBLE');
    }
}