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
        Schema::create('direccions', function (Blueprint $table) {
            $table->id();
            $table->string('cp');
            $table->unsignedBigInteger('provincia_id');
            $table->unsignedBigInteger('municipi_id');
            $table->foreign('provincia_id')->references('id')->on('provincies');
            $table->foreign('municipi_id')->references('id')->on('municipis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
