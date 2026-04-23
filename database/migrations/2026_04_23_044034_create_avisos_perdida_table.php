<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000021_create_avisos_perdida_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('avisos_perdida', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->unique()->constrained('publicaciones')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('animal_id')->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('fecha_perdida');
            $table->text('lugar_perdida');
            $table->text('descripcion')->nullable();
            $table->string('contacto', 150)->nullable();
            $table->enum('estado', ['ACTIVO', 'ENCONTRADO', 'CERRADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('avisos_perdida'); }
};
