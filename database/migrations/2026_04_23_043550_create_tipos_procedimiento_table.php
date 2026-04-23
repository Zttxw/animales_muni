<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000003_create_tipos_procedimiento_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('tipos_procedimiento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->boolean('requiere_detalle')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tipos_procedimiento'); }
};