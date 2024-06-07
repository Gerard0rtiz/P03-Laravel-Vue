<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('tecnologia_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->on('Users')->onDelete('cascade');
            $table->foreignId('idTecnologia')->on('Tecnologias')->onDelete('cascade');
            $table->integer('nivel')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tecnologia_user');
    }
};
