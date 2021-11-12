<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksSubwalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks_subwallets', function (Blueprint $table) {
            $table->id('stocks_subwallet_id');

            $table->integer('target_percentage');
            $table->integer('amount_of_stocks');
            $table->decimal('ceiling_price');

            $table->unsignedBigInteger('subwallet_id');
            $table->foreign('subwallet_id')->references('subwallet_id')->on('subwallets')->onDelete('cascade');;
            $table->unsignedBigInteger('stocks_id');
            $table->foreign('stocks_id')->references('stocks_id')->on('stocks');

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
        Schema::dropIfExists('stocks_subwallets');
    }
}
