<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFfianzaa extends Migration
{
    public function up()
    {
        Schema::create('factura_fianza', function (Blueprint $table) {
            $table->unsignedBigInteger('factura_id');
            $table->unsignedBigInteger('fianza_id');
            $table->decimal('precio', 8, 2); // Precio de la fianza en la factura
            $table->timestamps();

            // Clave primaria compuesta
            $table->primary(['factura_id', 'fianza_id']);

            // Definición de claves foráneas
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->foreign('fianza_id')->references('nu_fianza')->on('fianzas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('factura_fianza');
    }
}
