<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens__compras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quant');
            $table->decimal('preco', 10, 2);
            $table->decimal('total', 10, 2);
            $table->integer('compras_id')->unsigned();
            $table->foreign('compras_id')->references('id')->on('compras')->onDelete('cascade');
            $table->integer('insumos_id')->unsigned();
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
        Schema::dropIfExists('itens__compras');
    }
}
