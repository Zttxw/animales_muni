<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000024_create_notificaciones_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('tipo', ['CAMPAÑA', 'PARTICIPACION', 'AVISO', 'ADMIN', 'SISTEMA']);
            $table->string('titulo', 200)->nullable();
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->string('notifiable_type', 60)->nullable();
            $table->unsignedBigInteger('notifiable_id')->nullable();
            $table->timestamp('created_at')->nullable();
 
            $table->index(['usuario_id', 'leido'], 'idx_usuario_leido');
            $table->index(['notifiable_type', 'notifiable_id'], 'idx_notifiable');
        });
    }
    public function down(): void { Schema::dropIfExists('notificaciones'); }
};