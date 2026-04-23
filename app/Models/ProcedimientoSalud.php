<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcedimientoSalud extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'procedimientos_salud';

    protected $fillable = [
        'animal_id', 'tipo_procedimiento_id', 'tipo_detalle',
        'fecha', 'descripcion', 'observaciones',
        'archivo_url', 'registrado_por', 'campana_id',
    ];

    protected $casts = [
        'fecha'      => 'date',
        'created_at' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function tipoProcedimiento()
    {
        return $this->belongsTo(TipoProcedimiento::class, 'tipo_procedimiento_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }

    public function campana()
    {
        return $this->belongsTo(Campana::class, 'campana_id');
    }
}