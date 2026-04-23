<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000008_create_animales_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('animales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_municipal', 20)->unique()->comment('SJ-YYYY-NNNNNN');
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnUpdate();
            $table->foreignId('especie_id')->constrained('especies')->cascadeOnUpdate();
            $table->foreignId('raza_id')->nullable()->constrained('razas')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 100);
            $table->enum('sexo', ['M', 'H', 'DESCONOCIDO'])->default('DESCONOCIDO');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('edad_aproximada', 30)->nullable();
            $table->string('color', 100)->nullable();
            $table->enum('tamano', ['PEQUEÑO', 'MEDIANO', 'GRANDE', 'GIGANTE'])->nullable();
            $table->enum('estado_reproductivo', ['ENTERO', 'ESTERILIZADO', 'CASTRADO', 'DESCONOCIDO'])->nullable();
            $table->text('senas_particulares')->nullable();
            $table->enum('estado', ['ACTIVO', 'PERDIDO', 'EN_ADOPCION', 'FALLECIDO'])->default('ACTIVO');
            $table->text('observaciones')->nullable();
            $table->date('fecha_fallecimiento')->nullable();
            $table->text('motivo_fallecimiento')->nullable();
            $table->softDeletes();
            $table->timestamps();
 
            $table->index('usuario_id', 'idx_usuario');
            $table->index('especie_id', 'idx_especie');
            $table->index('estado', 'idx_estado');
            $table->index('codigo_municipal', 'idx_codigo');
        });
    }
    public function down(): void { Schema::dropIfExists('animales'); }
};
 