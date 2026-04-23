<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacunacion extends Model
{
    use HasFactory;

    protected $table = 'vacunaciones';

    protected $fillable = [
        'animal_id', 'vacuna_id', 'nombre_vacuna',
        'fecha_aplicacion', 'proxima_fecha', 'observaciones',
        'archivo_url', 'registrado_por', 'campana_id',
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'proxima_fecha'    => 'date',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function vacunaCatalogo()
    {
        return $this->belongsTo(VacunaCatalogo::class, 'vacuna_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }

    public function campana()
    {
        return $this->belongsTo(Campana::class, 'campana_id');
    }

    public function scopeProximas($query, int $dias = 30)
    {
        return $query->whereBetween('proxima_fecha', [now(), now()->addDays($dias)]);
    }
}