<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permisos ──────────────────────────────────────────
        $permisos = [
            // Usuarios
            'usuarios.ver', 'usuarios.crear', 'usuarios.editar', 'usuarios.eliminar',
            // Animales
            'animales.ver', 'animales.crear', 'animales.editar', 'animales.eliminar',
            // Vacunaciones
            'vacunaciones.ver', 'vacunaciones.crear', 'vacunaciones.editar',
            // Procedimientos
            'procedimientos.ver', 'procedimientos.crear', 'procedimientos.editar',
            // Adopciones
            'adopciones.ver', 'adopciones.crear', 'adopciones.revisar',
            // Campañas
            'campanas.ver', 'campanas.crear', 'campanas.editar', 'campanas.eliminar',
            // Publicaciones
            'publicaciones.ver', 'publicaciones.crear', 'publicaciones.editar', 'publicaciones.moderar',
            // Callejeros
            'callejeros.ver', 'callejeros.crear', 'callejeros.editar',
            // Reportes
            'reportes.ver', 'reportes.exportar',
            // Auditoría
            'auditoria.ver',
            // Dashboard admin
            'dashboard.admin',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // ── Roles ─────────────────────────────────────────────
        $admin = Role::firstOrCreate(['name' => 'ADMIN', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        $veterinario = Role::firstOrCreate(['name' => 'VETERINARIO', 'guard_name' => 'web']);
        $veterinario->givePermissionTo([
            'animales.ver', 'animales.editar',
            'vacunaciones.ver', 'vacunaciones.crear', 'vacunaciones.editar',
            'procedimientos.ver', 'procedimientos.crear', 'procedimientos.editar',
            'campanas.ver',
            'callejeros.ver', 'callejeros.crear', 'callejeros.editar',
        ]);

        $ciudadano = Role::firstOrCreate(['name' => 'CIUDADANO', 'guard_name' => 'web']);
        $ciudadano->givePermissionTo([
            'animales.ver', 'animales.crear', 'animales.editar',
            'vacunaciones.ver', 'vacunaciones.crear',
            'adopciones.ver', 'adopciones.crear',
            'campanas.ver',
            'publicaciones.ver',
            'callejeros.ver', 'callejeros.crear',
        ]);
    }
}
