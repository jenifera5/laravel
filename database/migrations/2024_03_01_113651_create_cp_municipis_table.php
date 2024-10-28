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
        Schema::create('cp_municipis', function (Blueprint $table) {
            $table->string('cp');
            $table->unsignedBigInteger('id_municipi');
            $table->foreign('id_municipi')->references('id')->on('municipis');
            $table->primary(['cp','id_municipi']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cp_municipis');
    }
};
