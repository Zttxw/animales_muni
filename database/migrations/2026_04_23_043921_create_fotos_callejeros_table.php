<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000015_create_fotos_callejeros_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('fotos_callejeros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callejero_id')->constrained('animales_callejeros')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('url', 500);
            $table->timestamp('created_at')->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('fotos_callejeros'); }
};