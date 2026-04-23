<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000014_create_animales_callejeros_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('animales_callejeros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique()->comment('SJ-C-YYYY-NNNNNN');
            $table->foreignId('especie_id')->nullable()->constrained('especies')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('raza_id')->nullable()->constrained('razas')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('sexo_aprox', ['M', 'H', 'DESCONOCIDO'])->default('DESCONOCIDO');
            $table->string('color', 100)->nullable();
            $table->enum('tamano', ['PEQUEÑO', 'MEDIANO', 'GRANDE', 'GIGANTE'])->nullable();
            $table->text('ubicacion');
            $table->enum('estado', ['OBSERVADO', 'RESCATADO', 'EN_TRATAMIENTO', 'EN_ADOPCION', 'FALLECIDO', 'LIBERADO'])->default('OBSERVADO');
            $table->text('observaciones')->nullable();
            $table->foreignId('reportado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
 
            $table->index('estado', 'idx_estado');
            $table->index('especie_id', 'idx_especie');
        });
    }
    public function down(): void { Schema::dropIfExists('animales_callejeros'); }
};