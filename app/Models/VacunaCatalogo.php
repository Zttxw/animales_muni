<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VacunaCatalogo extends Model
{
    use HasFactory;

    protected $table = 'vacunas_catalogo';

    protected $fillable = ['nombre', 'descripcion', 'especie_id', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'vacuna_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorEspecie($query, ?int $especieId)
    {
        return $query->where(function ($q) use ($especieId) {
            $q->whereNull('especie_id')->orWhere('especie_id', $especieId);
        });
    }
}