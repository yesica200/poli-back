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
        Schema::create('denuncia', function (Blueprint $table) {
            $table->id('id_denuncia');
            $table->string('descripcion')->nullable();
            $table->string('modulo_epi')->nullable();
            $table->time('hora')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo')->nullable();
            $table->string('calle_avenida')->nullable();
            $table->string('evidencia')->nullable();
            $table->string('estado')->nullable();
            $table->unsignedBigInteger('id_ciudadano')->nullable();
            $table->unsignedBigInteger('id_policia')->nullable();
            $table->boolean('fue_modificada')->default(0);

            $table->foreign('id_ciudadano')->references('id_ciudadano')->on('ciudadano')->onDelete('set null');
            $table->foreign('id_policia')->references('id_policia')->on('policia')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncia');
    }
};
