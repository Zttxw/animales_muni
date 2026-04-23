<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialAnimal extends Model
{
    public $timestamps  = false;
    public $updatedAt   = false;

    protected $table = 'historial_animales';

    protected $fillable = [
        'animal_id', 'usuario_id', 'tipo_cambio', 'descripcion', 'datos_previos',
    ];

    protected $casts = [
        'datos_previos' => 'array',
        'created_at'    => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}