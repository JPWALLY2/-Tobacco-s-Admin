<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens__vendas', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('quilo', 10, 2);
            $table->decimal('preco', 10, 2);
            $table->decimal('total', 10, 2);
            $table->integer('vendas_id')->unsigned();
            $table->foreign('vendas_id')->references('id')->on('vendas')->onDelete('cascade');
            $table->integer('estoques_id')->unsigned();
            $table->foreign('estoques_id')->references('id')->on('estoques');   
            $table->integer('classes_id')->unsigned();
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
        Schema::dropIfExists('itens__vendas');
    }
}
