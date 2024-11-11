<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('especialidads', function (Blueprint $table) {
            $table->id(); // ID de la especialidad
            $table->string('nombre')->unique(); // Nombre de la especialidad
            $table->text('descripcion')->nullable(); // Descripción de la especialidad
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidads');
    }
};
