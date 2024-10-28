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
        Schema::create('albarans', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->text('observacions')->nullable();

            $table->unsignedBigInteger('ordenes_trabajo_id');
            $table->foreign('ordenes_trabajo_id')->references('id')->on('ordenes_trabajo');

            $table->unsignedBigInteger('descuentos_id')->nullable();
            $table->foreign('descuentos_id')->references('id')->on('descuentos');

            $table->unsignedBigInteger('clients_id');
            $table->foreign('clients_id')->references('id')->on('clients');


            $table->unsignedBigInteger('precio_id')->nullable();

            $table->foreign('precio_id')->references('id')->on('price');

            $table->decimal('iva', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albarans');
    }
};
