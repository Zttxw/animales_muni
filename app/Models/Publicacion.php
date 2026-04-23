<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publicaciones';

    protected $fillable = [
        'tipo_publicacion_id', 'titulo', 'contenido',
        'autor_id', 'estado', 'animal_id',
    ];

    const ESTADO_BORRADOR    = 'BORRADOR';
    const ESTADO_PUBLICADO   = 'PUBLICADO';
    const ESTADO_DESACTIVADO = 'DESACTIVADO';
    const ESTADO_DESTACADO   = 'DESTACADO';

    // ── Relaciones ────────────────────────────────────────────
    public function tipoPublicacion()
    {
        return $this->belongsTo(TipoPublicacion::class, 'tipo_publicacion_id');
    }

    public function autor()
    {
        return $this->belongsTo(Usuario::class, 'autor_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoPublicacion::class, 'publicacion_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'publicacion_id')
                    ->where('estado', 'VISIBLE')
                    ->latest();
    }

    public function avisoPerdida()
    {
        return $this->hasOne(AvisoPerdida::class, 'publicacion_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopePublicado($query)
    {
        return $query->whereIn('estado', [self::ESTADO_PUBLICADO, self::ESTADO_DESTACADO]);
    }

    public function scopeDestacado($query)
    {
        return $query->where('estado', self::ESTADO_DESTACADO);
    }
}