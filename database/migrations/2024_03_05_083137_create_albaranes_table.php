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
        Schema::create('albaranes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_orden_trabajo');
            $table->foreign('id_orden_trabajo')->references('id')->on('ordenes_trabajo')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('material');
            $table->time('horas');
            $table->string('operario');
            $table->decimal('descuentos', 10, 2);
            $table->text('observaciones')->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('iva', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albaranes');
    }
};
