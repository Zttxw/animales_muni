<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombres', 'apellidos', 'documento_identidad', 'fecha_nacimiento',
        'sexo', 'telefono', 'correo', 'direccion', 'sector',
        'password', 'estado', 'token_recuperacion', 'token_expira_en', 'ultimo_acceso',
    ];

    protected $hidden = ['password', 'remember_token', 'token_recuperacion'];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'token_expira_en'  => 'datetime',
        'ultimo_acceso'    => 'datetime',
        'password'         => 'hashed',
    ];

    // ── Auth overrides (campo correo en vez de email) ────────
    public function getAuthIdentifierName(): string { return 'id'; }
    public function getEmailForPasswordReset(): string { return $this->correo; }

    /**
     * Laravel usa 'email' por defecto para login.
     * Como nuestra columna se llama 'correo', sobreescribimos.
     */
    public function getEmailAttribute(): string
    {
        return $this->correo;
    }

    // ── Accessors ────────────────────────────────────────────
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    // ── Relaciones ────────────────────────────────────────────
    public function animales()
    {
        return $this->hasMany(Animal::class, 'usuario_id');
    }

    public function participaciones()
    {
        return $this->hasMany(ParticipacionCampana::class, 'usuario_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'autor_id');
    }

    public function auditoria()
    {
        return $this->hasMany(Auditoria::class, 'usuario_id');
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeActivo($query)
    {
        return $query->where('estado', 'ACTIVO');
    }

    public function scopeSuspendido($query)
    {
        return $query->where('estado', 'SUSPENDIDO');
    }
}