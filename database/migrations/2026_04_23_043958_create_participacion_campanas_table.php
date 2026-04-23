<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000018_create_participacion_campanas_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('participacion_campanas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campana_id')->constrained('campanas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('animal_id')->nullable()->constrained('animales')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('asistencia')->default(false);
            $table->timestamp('created_at')->nullable();
 
            $table->unique(['campana_id', 'usuario_id', 'animal_id'], 'uq_participacion');
            $table->index('campana_id', 'idx_campana');
            $table->index('usuario_id', 'idx_usuario');
        });
    }
    public function down(): void { Schema::dropIfExists('participacion_campanas'); }
};