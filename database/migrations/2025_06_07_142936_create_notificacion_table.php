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
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id('id_notificacion');
            $table->string('titulo')->nullable();
            $table->string('descripcion')->nullable();
            $table->time('hora')->nullable();
            $table->date('fecha')->nullable();
            $table->string('estado')->nullable();
            $table->unsignedBigInteger('id_policia')->nullable();
            $table->unsignedBigInteger('id_ciudadano')->nullable();

            $table->foreign('id_policia')->references('id_policia')->on('policia')->onDelete('set null');
            $table->foreign('id_ciudadano')->references('id_ciudadano')->on('ciudadano')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
