<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000013_create_adopciones_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('adopciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->unique()->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('motivo')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();
            $table->string('contacto', 150)->nullable();
            $table->enum('estado', ['DISPONIBLE', 'EN_PROCESO', 'ADOPTADO', 'RETIRADO'])->default('DISPONIBLE');
            $table->text('observacion_admin')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('fecha_revision')->nullable();
            $table->timestamps();
 
            $table->index('estado', 'idx_estado');
        });
    }
    public function down(): void { Schema::dropIfExists('adopciones'); }
};