<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000022_create_fotos_publicaciones_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('fotos_publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('url', 500);
            $table->timestamp('created_at')->nullable();
 
            $table->index('publicacion_id', 'idx_publicacion');
        });
    }
    public function down(): void { Schema::dropIfExists('fotos_publicaciones'); }
};
