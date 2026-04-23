<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000007_create_vacunas_catalogo_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('vacunas_catalogo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('especie_id')->nullable()->constrained('especies')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('vacunas_catalogo'); }
};
