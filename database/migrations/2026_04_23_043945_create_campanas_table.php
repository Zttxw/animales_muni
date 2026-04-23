<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000017_create_campanas_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('campanas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->foreignId('tipo_campana_id')->constrained('tipos_campana')->cascadeOnUpdate();
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->string('lugar', 200)->nullable();
            $table->unsignedSmallInteger('capacidad')->nullable();
            $table->enum('estado', ['BORRADOR', 'PUBLICADA', 'EN_CURSO', 'FINALIZADA', 'CANCELADA'])->default('BORRADOR');
            $table->text('publico_objetivo')->nullable();
            $table->text('requisitos')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
 
            $table->index('estado', 'idx_estado');
            $table->index('fecha', 'idx_fecha');
            $table->index('tipo_campana_id', 'idx_tipo_campana');
        });
    }
    public function down(): void { Schema::dropIfExists('campanas'); }
};