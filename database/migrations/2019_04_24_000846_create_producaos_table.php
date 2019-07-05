<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producaos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('quilo', 10, 2);
            $table->integer('estoques_id')->unsigned();
            $table->foreign('estoques_id')->references('id')->on('estoques')->onDelete('cascade');   
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
        Schema::dropIfExists('producaos');
    }
}
