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
            $table->string('telefon')->nullable();
            $table->string('telefon2')->nullable();
            $table->string('email');
            $table->string('contacte');
            $table->boolean('encurs')->nullable();
            $table->double('diacobrament')->nullable();
            $table->string('observacions')->nullable();



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
