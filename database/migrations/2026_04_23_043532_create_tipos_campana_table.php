<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000002_create_tipos_campana_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('tipos_campana', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->string('icono', 50)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tipos_campana'); }
};