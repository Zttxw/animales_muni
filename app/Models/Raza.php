<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Raza extends Model
{
    use HasFactory;

    protected $table = 'razas';

    protected $fillable = ['especie_id', 'nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    // ── Relaciones ────────────────────────────────────────────
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function animales()
    {
        return $this->hasMany(Animal::class, 'raza_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorEspecie($query, int $especieId)
    {
        return $query->where('especie_id', $especieId);
    }
}