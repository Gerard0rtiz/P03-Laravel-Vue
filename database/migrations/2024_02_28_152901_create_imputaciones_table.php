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
        Schema::create('imputaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('User')->onDelete('cascade');
            $table->unsignedBigInteger('idProyecto');
            $table->foreign('idProyecto')->references('id')->on('Proyecto')->onDelete('cascade');
            $table->nombreJefe();
            $table->fechaImputacion();
            $table->horasRealizadas();
            $table->descripcion();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imputaciones');
    }
};
