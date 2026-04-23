<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProcedimiento extends Model
{
    protected $table = 'tipos_procedimiento';

    protected $fillable = ['nombre', 'descripcion', 'requiere_detalle', 'activo'];

    protected $casts = [
        'requiere_detalle' => 'boolean',
        'activo'           => 'boolean',
    ];

    public function procedimientos()
    {
        return $this->hasMany(ProcedimientoSalud::class, 'tipo_procedimiento_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}