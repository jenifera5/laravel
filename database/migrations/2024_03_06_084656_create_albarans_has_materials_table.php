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
        Schema::create('albarans_has_materials', function (Blueprint $table) {
            $table->id();
            $table->foreign('albaran_id')->references('id')->on('albarans');
            $table->unsignedBigInteger('albaran_id');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->unsignedBigInteger('material_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albarans_has_materials');
    }
};
