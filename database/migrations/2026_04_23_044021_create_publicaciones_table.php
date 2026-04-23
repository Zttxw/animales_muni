<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000020_create_publicaciones_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_publicacion_id')->constrained('tipos_publicacion')->cascadeOnUpdate();
            $table->string('titulo', 200);
            $table->longText('contenido')->nullable();
            $table->foreignId('autor_id')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->enum('estado', ['BORRADOR', 'PUBLICADO', 'DESACTIVADO', 'DESTACADO'])->default('BORRADOR');
            $table->foreignId('animal_id')->nullable()->constrained('animales')->nullOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
 
            $table->index('tipo_publicacion_id', 'idx_tipo');
            $table->index('estado', 'idx_estado');
            $table->index('autor_id', 'idx_autor');
        });
    }
    public function down(): void { Schema::dropIfExists('publicaciones'); }
};
