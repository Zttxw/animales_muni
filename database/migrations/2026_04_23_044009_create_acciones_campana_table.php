<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000019_create_acciones_campana_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('acciones_campana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campana_id')->constrained('campanas')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('animal_id')->nullable()->constrained('animales')->nullOnDelete()->cascadeOnUpdate();
            $table->string('tipo_accion', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->nullable()->useCurrent();
 
            $table->index('campana_id', 'idx_campana');
            $table->index('animal_id', 'idx_animal');
        });
    }
    public function down(): void { Schema::dropIfExists('acciones_campana'); }
};