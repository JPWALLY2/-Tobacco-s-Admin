<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimativas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('arroba');            
            $table->decimal('quant', 10, 2);            
            $table->decimal('totalQuilo', 10, 2);            
            $table->decimal('media', 10, 2);            
            $table->decimal('valorTotal', 10, 2);            
            $table->decimal('valorInsumo', 10, 2);            
            $table->decimal('subTotal', 10, 2); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimativas');
    }
}
