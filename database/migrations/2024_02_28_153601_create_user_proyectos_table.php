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
        Schema::create('user_proyectos', function (Blueprint $table) {
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('Users')->onDelete('cascade');
            $table->unsignedBigInteger('idProyecto');
            $table->foreign('idProyecto')->references('id')->on('Proyectos')->onDelete('cascade');
            $table->primary(['idUser','idProyecto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_proyectos');
    }
};
