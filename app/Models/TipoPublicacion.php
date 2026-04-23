<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPublicacion extends Model
{
    protected $table = 'tipos_publicacion';

    protected $fillable = ['nombre', 'descripcion', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'tipo_publicacion_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}