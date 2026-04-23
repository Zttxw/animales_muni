<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    public $timestamps = false;
    public $updatedAt  = false;

    protected $table = 'auditoria';

    protected $fillable = [
        'usuario_id', 'accion', 'tabla', 'registro_id',
        'ip', 'user_agent', 'datos',
    ];

    protected $casts = [
        'datos'      => 'array',
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Registra un evento de auditoría desde cualquier parte de la app.
     */
    public static function registrar(
        string  $accion,
        ?string $tabla      = null,
        ?int    $registroId = null,
        ?array  $datos      = null
    ): self {
        return static::create([
            'usuario_id'  => auth()->id(),
            'accion'      => $accion,
            'tabla'       => $tabla,
            'registro_id' => $registroId,
            'ip'          => request()?->ip(),
            'user_agent'  => request()?->userAgent(),
            'datos'       => $datos,
        ]);
    }
}