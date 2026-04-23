<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Especie extends Model
{
    use HasFactory;

    protected $table = 'especies';

    protected $fillable = ['nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    // ── Relaciones ────────────────────────────────────────────
    public function razas()
    {
        return $this->hasMany(Raza::class, 'especie_id');
    }

    public function animales()
    {
        return $this->hasMany(Animal::class, 'especie_id');
    }

    public function vacunasCatalogo()
    {
        return $this->hasMany(VacunaCatalogo::class, 'especie_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}