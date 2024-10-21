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
        Schema::create('proveidors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nif');
            $table->string('telefon');
            $table->string('telefon2');
            $table->string('email');
            $table->string('contacte');
            $table->boolean('enCurs');
            $table->string('diaCobrament');
            $table->string('observacions');
            $table->unsignedBigInteger('direccio_id');
            $table->unsignedBigInteger('provincia_id');
            $table->foreign('direccio_id')->references('id')->on('direccions');
            $table->foreign('provincia_id')->references('id')->on('provincies');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveidors');
    }
};
