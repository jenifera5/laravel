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
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('familia_id');
            $table->text('description');
            $table->integer('stock');
            $table->string('numero_serie')->nullable();
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('familia_id')->references('id')->on('familias'); 
            $table->foreign('proveedor_id')->references('id')->on('proveedores'); 
            $table->decimal('precioCoste', 8, 2); 
            $table->decimal('pvp', 8, 2);
            $table->boolean('encurso')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
        //materiales  jenifer 2
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
