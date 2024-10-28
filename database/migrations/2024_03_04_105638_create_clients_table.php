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
            $table->string('name')->nullable();
            $table->string('surname1')->nullable();
            $table->string('surname2')->nullable();
            $table->string('nif')->nullable();
            $table->string('telefon')->nullable();
            $table->string('telefon2')->nullable();
            $table->string('email')->nullable();


            //->nullable()->unique();

            $table->unsignedBigInteger('idioma_id');
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
