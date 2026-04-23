<?php
// ============================================================
// App\Models\FotoAnimal
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoAnimal extends Model
{
    public $timestamps = false;

    protected $table = 'fotos_animales';

    protected $fillable = ['animal_id', 'url', 'es_portada'];

    protected $casts = [
        'es_portada' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }
}