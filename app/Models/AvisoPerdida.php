<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvisoPerdida extends Model
{
    protected $table = 'avisos_perdida';

    protected $fillable = [
        'publicacion_id', 'animal_id', 'fecha_perdida',
        'lugar_perdida', 'descripcion', 'contacto', 'estado',
    ];

    protected $casts = ['fecha_perdida' => 'date'];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('estado', 'ACTIVO');
    }
}