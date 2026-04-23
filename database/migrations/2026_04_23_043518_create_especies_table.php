<?php

// ============================================================
// ARCHIVO: database/migrations/2024_01_01_000001_create_especies_table.php
// ============================================================
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void {
        Schema::create('especies', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('especies'); }
};
