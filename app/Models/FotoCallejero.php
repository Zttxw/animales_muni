<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoCallejero extends Model
{
    public $timestamps = false;

    protected $table = 'fotos_callejeros';

    protected $fillable = ['callejero_id', 'url'];

    protected $casts = ['created_at' => 'datetime'];

    public function callejero()
    {
        return $this->belongsTo(AnimalCallejero::class, 'callejero_id');
    }
}