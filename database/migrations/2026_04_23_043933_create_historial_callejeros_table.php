<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000016_create_historial_callejeros_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('historial_callejeros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callejero_id')->constrained('animales_callejeros')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('estado_nuevo', ['OBSERVADO', 'RESCATADO', 'EN_TRATAMIENTO', 'EN_ADOPCION', 'FALLECIDO', 'LIBERADO']);
            $table->text('descripcion')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->nullable()->useCurrent();
 
            $table->index('callejero_id', 'idx_callejero');
        });
    }
    public function down(): void { Schema::dropIfExists('historial_callejeros'); }
};