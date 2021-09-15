<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('stocks_id');

            $table->string('name');
            $table->unsignedBigInteger('stock_types_id');
            $table->foreign('stock_types_id')->references('stock_types_id')->on('stock_types');
            $table->decimal('actual_price')->nullable();
            $table->decimal('previous_close')->nullable();
            $table->decimal('variation')->nullable();
            $table->decimal('perc_variation')->nullable();

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
        Schema::dropIfExists('stocks');
    }
}
