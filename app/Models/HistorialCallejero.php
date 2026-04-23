<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCallejero extends Model
{
    public $timestamps = false;
    public $updatedAt  = false;

    protected $table = 'historial_callejeros';

    protected $fillable = ['callejero_id', 'estado_nuevo', 'descripcion', 'registrado_por'];

    protected $casts = ['created_at' => 'datetime'];

    public function callejero()
    {
        return $this->belongsTo(AnimalCallejero::class, 'callejero_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }
}