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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname1');
            $table->string('surname2');
            $table->string('nif');
            $table->text('direccio');
            $table->string('telefon');
            $table->string('telefon2');
            $table->string('email');

            $table->unsignedBigInteger('cp_id');
            $table->unsignedBigInteger('idioma_id');
            $table->unsignedBigInteger('provincia_id');

            $table->foreign('cp_id')->references('id')->on('cps');
            $table->foreign('provincia_id')->references('id')->on('provincies');
            $table->foreign('idioma_id')->references('id')->on('idiomes');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
