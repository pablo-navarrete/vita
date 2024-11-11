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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('rut')->unique();
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->string('telefono')->nullable();
            $table->string('email')->unique();
            $table->string('direccion')->nullable();
            $table->foreignId('id_pais')->constrained('pais')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('especialidad_id')->nullable(); // Columna foránea
            
            // Definición de la relación foránea
            $table->foreign('especialidad_id')->references('id')->on('especialidads')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['especialidad_id']); // Eliminar la relación foránea
        });

        Schema::dropIfExists('users');
    }
};
