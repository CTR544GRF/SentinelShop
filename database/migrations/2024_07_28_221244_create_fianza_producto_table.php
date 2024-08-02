<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFianzaProductoTable extends Migration
{
    public function up()
    {
        Schema::create('fianza_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fianza_nu_fianza');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->timestamps();
    
            // Agregar claves foráneas
            $table->foreign('fianza_nu_fianza')->references('nu_fianza')->on('fianzas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fianza_producto');
    }
}