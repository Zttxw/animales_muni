<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000009_create_fotos_animales_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('fotos_animales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animales')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('url', 500);
            $table->boolean('es_portada')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('fotos_animales'); }
};