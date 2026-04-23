<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000025_create_auditoria_table.php
// ============================================================
return new class extends Migration {
    public function up(): void {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete()->cascadeOnUpdate();
            $table->string('accion', 60);
            $table->string('tabla', 60)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 300)->nullable();
            $table->json('datos')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
 
            $table->index('usuario_id', 'idx_usuario');
            $table->index(['tabla', 'registro_id'], 'idx_tabla');
            $table->index('created_at', 'idx_created_at');
        });
    }
    public function down(): void { Schema::dropIfExists('auditoria'); }
};
 