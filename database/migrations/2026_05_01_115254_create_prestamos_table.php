<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained()->onDelete('cascade');
            $table->foreignId('libro_id')->constrained()->onDelete('cascade');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
            $table->enum('estado', ['P', 'D'])->default('P');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
