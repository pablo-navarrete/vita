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
        Schema::create('pre_consultas', function (Blueprint $table) {
            $table->id(); // ID auto-incremental
            $table->foreignId('paciente_id')->references('id')->on('pacientes');
            $table->foreignId('cita_id')->references('id')->on('citas');
            $table->string('motivo_consulta'); // Motivo de la consulta
            $table->text('sintomas')->nullable(); // Síntomas presentados
            $table->text('observaciones')->nullable(); // Observaciones adicionales
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_consultas');
    }
};
