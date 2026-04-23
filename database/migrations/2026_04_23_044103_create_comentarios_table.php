<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000023_create_comentarios_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('contenido');
            $table->enum('estado', ['VISIBLE', 'OCULTO', 'ELIMINADO'])->default('VISIBLE');
            $table->foreignId('moderado_por')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->string('motivo_moderacion', 255)->nullable();
            $table->timestamps();
 
            $table->index('publicacion_id', 'idx_publicacion');
            $table->index('estado', 'idx_estado');
        });
    }
    public function down(): void { Schema::dropIfExists('comentarios'); }
};