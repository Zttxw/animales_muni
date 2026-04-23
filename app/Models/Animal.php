<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'animales';

    protected $fillable = [
        'codigo_municipal', 'usuario_id', 'especie_id', 'raza_id',
        'nombre', 'sexo', 'fecha_nacimiento', 'edad_aproximada',
        'color', 'tamano', 'estado_reproductivo', 'senas_particulares',
        'estado', 'observaciones', 'fecha_fallecimiento', 'motivo_fallecimiento',
    ];

    protected $casts = [
        'fecha_nacimiento'    => 'date',
        'fecha_fallecimiento' => 'date',
    ];

    // ── Constantes de estado ──────────────────────────────────
    const ESTADO_ACTIVO      = 'ACTIVO';
    const ESTADO_PERDIDO     = 'PERDIDO';
    const ESTADO_EN_ADOPCION = 'EN_ADOPCION';
    const ESTADO_FALLECIDO   = 'FALLECIDO';

    // ── Boot: auto-generar código ────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Animal $animal) {
            if (empty($animal->codigo_municipal)) {
                $animal->codigo_municipal = static::generarCodigo();
            }
        });
    }

    // ── Relaciones ────────────────────────────────────────────
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class, 'raza_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoAnimal::class, 'animal_id');
    }

    public function fotoPortada()
    {
        return $this->hasOne(FotoAnimal::class, 'animal_id')->where('es_portada', true);
    }

    public function historial()
    {
        return $this->hasMany(HistorialAnimal::class, 'animal_id')->latest('created_at');
    }

    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'animal_id')->latest('fecha_aplicacion');
    }

    public function procedimientos()
    {
        return $this->hasMany(ProcedimientoSalud::class, 'animal_id')->latest('fecha');
    }

    public function adopcion()
    {
        return $this->hasOne(Adopcion::class, 'animal_id');
    }

    public function avisosPerdida()
    {
        return $this->hasMany(AvisoPerdida::class, 'animal_id');
    }

    public function participaciones()
    {
        return $this->hasMany(ParticipacionCampana::class, 'animal_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeActivo($query)
    {
        return $query->where('estado', self::ESTADO_ACTIVO);
    }

    public function scopePerdido($query)
    {
        return $query->where('estado', self::ESTADO_PERDIDO);
    }

    public function scopeEnAdopcion($query)
    {
        return $query->where('estado', self::ESTADO_EN_ADOPCION);
    }

    public function scopePorPropietario($query, int $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // ── Helpers ───────────────────────────────────────────────
    public static function generarCodigo(): string
    {
        $anio   = date('Y');
        $ultimo = static::withTrashed()
            ->where('codigo_municipal', 'like', "SJ-{$anio}-%")
            ->count();
        return sprintf('SJ-%s-%06d', $anio, $ultimo + 1);
    }

    public function registrarHistorial(
        string  $tipoCambio,
        ?string $descripcion = null,
        ?array  $datosPrevios = null,
        ?int    $usuarioId = null
    ): HistorialAnimal {
        return $this->historial()->create([
            'tipo_cambio'   => $tipoCambio,
            'descripcion'   => $descripcion,
            'datos_previos' => $datosPrevios,
            'usuario_id'    => $usuarioId ?? auth()->id(),
        ]);
    }
}