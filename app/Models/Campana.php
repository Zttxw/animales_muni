<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campana extends Model
{
    use HasFactory;

    protected $table = 'campanas';

    protected $fillable = [
        'titulo', 'tipo_campana_id', 'descripcion',
        'fecha', 'hora', 'lugar', 'capacidad',
        'estado', 'publico_objetivo', 'requisitos', 'creado_por',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora'  => 'string',
    ];

    const ESTADO_BORRADOR   = 'BORRADOR';
    const ESTADO_PUBLICADA  = 'PUBLICADA';
    const ESTADO_EN_CURSO   = 'EN_CURSO';
    const ESTADO_FINALIZADA = 'FINALIZADA';
    const ESTADO_CANCELADA  = 'CANCELADA';

    // ── Relaciones ────────────────────────────────────────────
    public function tipoCampana()
    {
        return $this->belongsTo(TipoCampana::class, 'tipo_campana_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function participaciones()
    {
        return $this->hasMany(ParticipacionCampana::class, 'campana_id');
    }

    public function acciones()
    {
        return $this->hasMany(AccionCampana::class, 'campana_id');
    }

    public function vacunaciones()
    {
        return $this->hasMany(Vacunacion::class, 'campana_id');
    }

    public function procedimientos()
    {
        return $this->hasMany(ProcedimientoSalud::class, 'campana_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopePublicada($query)
    {
        return $query->where('estado', self::ESTADO_PUBLICADA);
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha', '>=', now()->toDateString())
                     ->whereIn('estado', [self::ESTADO_PUBLICADA, self::ESTADO_EN_CURSO]);
    }

    // ── Helpers ───────────────────────────────────────────────
    public function cuposDisponibles(): ?int
    {
        if (is_null($this->capacidad)) return null;
        return max(0, $this->capacidad - $this->participaciones()->count());
    }
}