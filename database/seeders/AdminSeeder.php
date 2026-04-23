<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Usuario::firstOrCreate(
            ['correo' => 'admin@siracom.gob.pe'],
            [
                'nombres'             => 'Administrador',
                'apellidos'           => 'SIRACOM',
                'documento_identidad' => '00000001',
                'sexo'                => 'M',
                'telefono'            => '984000001',
                'direccion'           => 'Municipalidad Distrital de San Jerónimo',
                'sector'              => 'Centro',
                'password'            => 'password',
                'estado'              => 'ACTIVO',
            ]
        );
        $admin->assignRole('ADMIN');

        // Veterinario de prueba
        $vet = Usuario::firstOrCreate(
            ['correo' => 'veterinario@siracom.gob.pe'],
            [
                'nombres'             => 'Carlos',
                'apellidos'           => 'Mendoza Quispe',
                'documento_identidad' => '00000002',
                'sexo'                => 'M',
                'telefono'            => '984000002',
                'direccion'           => 'Jr. Veterinaria 123',
                'sector'              => 'San Jerónimo',
                'password'            => 'password',
                'estado'              => 'ACTIVO',
            ]
        );
        $vet->assignRole('VETERINARIO');

        // Ciudadano de prueba
        $ciudadano = Usuario::firstOrCreate(
            ['correo' => 'ciudadano@siracom.gob.pe'],
            [
                'nombres'             => 'María',
                'apellidos'           => 'Huamán López',
                'documento_identidad' => '00000003',
                'sexo'                => 'F',
                'telefono'            => '984000003',
                'direccion'           => 'Av. La Cultura 456',
                'sector'              => 'Larapa',
                'password'            => 'password',
                'estado'              => 'ACTIVO',
            ]
        );
        $ciudadano->assignRole('CIUDADANO');
    }
}
