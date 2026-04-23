<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000006_create_razas_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('razas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especie_id')->constrained('especies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->unique(['especie_id', 'nombre'], 'uq_raza_especie');
        });
    }
    public function down(): void { Schema::dropIfExists('razas'); }
};