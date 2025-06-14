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
        Schema::create('ciudadano', function (Blueprint $table) {
            $table->id('id_ciudadano');
            $table->string('nombres')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('correo')->nullable();
            $table->string('contraseña')->nullable();
            $table->string('expo_push_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudadano');
    }
};
