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
        Schema::create('policia', function (Blueprint $table) {
            $table->id('id_policia');
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('correo')->nullable();
            $table->string('contraseña')->nullable();
             $table->string('expo_push_token')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->foreign('id_admin')->references('id_admin')->on('administrador')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policia');
    }
};
