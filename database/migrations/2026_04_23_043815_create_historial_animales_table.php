<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000010_create_historial_animales_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('historial_animales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->string('tipo_cambio', 60);
            $table->text('descripcion')->nullable();
            $table->json('datos_previos')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
 
            $table->index('animal_id', 'idx_animal');
            $table->index('tipo_cambio', 'idx_tipo');
        });
    }
    public function down(): void { Schema::dropIfExists('historial_animales'); }
};