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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->text('description');
            $table->integer('stock');
            $table->string('numero_serie')->nullable();
            $table->decimal('preciocoste', 8, 2);
            $table->decimal('pvp', 8, 2);
            $table->decimal('margen', 8, 2)->nullable();
            $table->boolean('encurs')->default(false);
            $table->text('observacions')->nullable();
            $table->string('img')->nullable();

            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->foreign('familia_id')->references('id')->on('familias');
            $table->unsignedBigInteger('familia_id')->nullable();
            $table->foreign('proveidor_id')->references('id')->on('proveidors');
            $table->unsignedBigInteger('proveidor_id')->nullable();

            $table->timestamps();
        });

        // Mi comentario
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};

