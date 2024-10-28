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
        Schema::create('direccions_proveidors', function (Blueprint $table) {
            $table->id();
            $table->string('carrer');
            $table->string('numero');
            $table->string('pis');
            $table->string('porta')->nullable();
            $table->string('observacions')->nullable();

            $table->string('cp_id');
            $table->unsignedBigInteger('provincia_id');
            $table->unsignedBigInteger('municipi_id');
            $table->unsignedBigInteger('proveidor_id');

            $table->foreign('provincia_id')->references('id')->on('provincies');
            $table->foreign('municipi_id')->references('id')->on('municipis');
            $table->foreign('cp_id')->references('cp')->on('cp_municipis');
            $table->foreign('proveidor_id')->references('id')->on('proveidors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions_proveidors');
    }
};
