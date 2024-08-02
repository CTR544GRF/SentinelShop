<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFianzasTable extends Migration
{
    public function up()
    {
        Schema::create('fianzas', function (Blueprint $table) {
            $table->id('nu_fianza');
            $table->unsignedBigInteger('user_id');
            $table->date('fecha');
            $table->decimal('precio', 8, 2);
            $table->boolean('estado');
            $table->text('descripcion')->nullable();
            $table->timestamps();
    
            // Agregar clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fianzas');
    }
}