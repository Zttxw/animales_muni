<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000005_create_usuarios_table.php
// NOTA: sin columna "rol" — los roles los maneja Spatie
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('documento_identidad', 20)->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['M', 'F', 'O'])->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 150)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('sector', 100)->nullable();
            $table->string('password', 255);
            $table->enum('estado', ['ACTIVO', 'SUSPENDIDO', 'INACTIVO'])->default('ACTIVO');
            $table->rememberToken();
            $table->string('token_recuperacion', 255)->nullable();
            $table->timestamp('token_expira_en')->nullable();
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamps();
 
            $table->index('documento_identidad', 'idx_documento');
            $table->index('correo', 'idx_correo');
            $table->index('estado', 'idx_estado');
        });
    }
    public function down(): void { Schema::dropIfExists('usuarios'); }
};