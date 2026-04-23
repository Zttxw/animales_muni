<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalCallejero extends Model
{
    use HasFactory;

    protected $table = 'animales_callejeros';

    protected $fillable = [
        'codigo', 'especie_id', 'raza_id', 'sexo_aprox',
        'color', 'tamano', 'ubicacion', 'estado',
        'observaciones', 'reportado_por',
    ];

    const ESTADOS = ['OBSERVADO', 'RESCATADO', 'EN_TRATAMIENTO', 'EN_ADOPCION', 'FALLECIDO', 'LIBERADO'];

    // ── Boot: auto-generar código ────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (AnimalCallejero $callejero) {
            if (empty($callejero->codigo)) {
                $callejero->codigo = static::generarCodigo();
            }
        });
    }

    // ── Relaciones ────────────────────────────────────────────
    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class, 'raza_id');
    }

    public function reportadoPor()
    {
        return $this->belongsTo(Usuario::class, 'reportado_por');
    }

    public function fotos()
    {
        return $this->hasMany(FotoCallejero::class, 'callejero_id');
    }

    public function historial()
    {
        return $this->hasMany(HistorialCallejero::class, 'callejero_id')->latest('created_at');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopePorEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    // ── Helpers ───────────────────────────────────────────────
    public static function generarCodigo(): string
    {
        $anio   = date('Y');
        $ultimo = static::where('codigo', 'like', "SJ-C-{$anio}-%")->count();
        return sprintf('SJ-C-%s-%06d', $anio, $ultimo + 1);
    }
}