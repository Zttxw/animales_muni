<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adopcion extends Model
{
    use HasFactory;

    protected $table = 'adopciones';

    protected $fillable = [
        'animal_id', 'motivo', 'descripcion', 'requisitos',
        'contacto', 'estado', 'observacion_admin',
        'revisado_por', 'fecha_revision',
    ];

    protected $casts = [
        'fecha_revision' => 'datetime',
    ];

    const ESTADO_DISPONIBLE  = 'DISPONIBLE';
    const ESTADO_EN_PROCESO  = 'EN_PROCESO';
    const ESTADO_ADOPTADO    = 'ADOPTADO';
    const ESTADO_RETIRADO    = 'RETIRADO';

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function revisadoPor()
    {
        return $this->belongsTo(Usuario::class, 'revisado_por');
    }

    public function scopeDisponible($query)
    {
        return $query->where('estado', self::ESTADO_DISPONIBLE);
    }
}