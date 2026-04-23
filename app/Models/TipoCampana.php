<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCampana extends Model
{
    protected $table = 'tipos_campana';

    protected $fillable = ['nombre', 'descripcion', 'icono', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function campanas()
    {
        return $this->hasMany(Campana::class, 'tipo_campana_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}