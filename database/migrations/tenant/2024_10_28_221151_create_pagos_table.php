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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente');
            $table->decimal('monto', 10, 2); // Ajusta el tamaño según tus necesidades
            $table->date('fecha_pago');
            $table->string('metodo_pago'); // Tarjeta, Efectivo, Transferencia, etc.
            $table->string('descripcion_servicio')->nullable(); // Opcional para describir el motivo del pago
            $table->enum('estado_pago', ['pendiente', 'completado', 'reembolsado'])->default('pendiente');
            $table->timestamps();

            // Relación con la tabla pacientes
            $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
