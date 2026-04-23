<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionCampana extends Model
{
    public $timestamps = false;

    protected $table = 'acciones_campana';

    protected $fillable = ['campana_id', 'animal_id', 'tipo_accion', 'descripcion', 'registrado_por'];

    protected $casts = ['created_at' => 'datetime'];

    public function campana()
    {
        return $this->belongsTo(Campana::class, 'campana_id');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }
}