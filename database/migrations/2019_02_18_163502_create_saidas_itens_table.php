<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaidasItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saidas_itens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('insumos_id')->unsigned();
            $table->foreign('insumos_id')->references('id')->on('insumos');
            $table->integer('quant')->nullable();
            $table->string('motivo')->nullable();
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
        Schema::dropIfExists('saidas_itens');
    }
}
