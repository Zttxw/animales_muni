<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipacionCampana extends Model
{
    public $timestamps = false;
    const UPDATED_AT   = null;

    protected $table = 'participacion_campanas';

    protected $fillable = ['campana_id', 'usuario_id', 'animal_id', 'asistencia'];

    protected $casts = [
        'asistencia' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function campana()
    {
        return $this->belongsTo(Campana::class, 'campana_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
}