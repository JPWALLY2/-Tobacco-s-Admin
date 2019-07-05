<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('tiposInsumos_id')->unsigned();
            $table->foreign('tiposInsumos_id')->references('id')->on('tipos_insumos');
            $table->integer('compras_id')->unsigned()->nullable();
            $table->foreign('compras_id')->references('id')->on('compras');
            $table->integer('marcas_id')->unsigned()->nullable();
            $table->foreign('marcas_id')->references('id')->on('marcas');
            $table->decimal('preco', 10, 2)->nullable();
            $table->integer('quant')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}
