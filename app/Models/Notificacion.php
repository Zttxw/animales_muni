<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    public $timestamps = false;
    const UPDATED_AT   = null;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id', 'tipo', 'titulo', 'mensaje',
        'leido', 'notifiable_type', 'notifiable_id',
    ];

    protected $casts = [
        'leido'      => 'boolean',
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /** Relación polimórfica hacia el recurso relacionado */
    public function notifiable()
    {
        return $this->morphTo('notifiable', 'notifiable_type', 'notifiable_id');
    }

    public function scopeNoLeidas($query)
    {
        return $query->where('leido', false);
    }

    public function marcarLeida(): void
    {
        $this->update(['leido' => true]);
    }
}