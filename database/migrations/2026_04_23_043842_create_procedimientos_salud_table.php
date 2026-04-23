<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000012_create_procedimientos_salud_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('procedimientos_salud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('tipo_procedimiento_id')->constrained('tipos_procedimiento')->cascadeOnUpdate();
            $table->string('tipo_detalle', 100)->nullable();
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('archivo_url', 500)->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('campana_id')->nullable();
            $table->timestamp('created_at')->nullable();
 
            $table->index('animal_id', 'idx_animal');
            $table->index('tipo_procedimiento_id', 'idx_tipo');
        });
    }
    public function down(): void { Schema::dropIfExists('procedimientos_salud'); }
};