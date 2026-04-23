<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000011_create_vacunaciones_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('vacunaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('vacuna_id')->nullable()->constrained('vacunas_catalogo')->nullOnDelete()->cascadeOnUpdate();
            $table->string('nombre_vacuna', 100);
            $table->date('fecha_aplicacion');
            $table->date('proxima_fecha')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('archivo_url', 500)->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('campana_id')->nullable();
            $table->timestamps();
 
            $table->index('animal_id', 'idx_animal');
            $table->index('proxima_fecha', 'idx_proxima');
        });
    }
    public function down(): void { Schema::dropIfExists('vacunaciones'); }
};