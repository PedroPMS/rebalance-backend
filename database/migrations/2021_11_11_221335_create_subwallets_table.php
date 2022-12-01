<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubwalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subwallets', function (Blueprint $table) {
            $table->id('subwallet_id');

            $table->integer('target_percentage');

            $table->unsignedBigInteger('wallet_id');
            $table->foreign('wallet_id')->references('wallet_id')->on('wallets')->onDelete('cascade');
            $table->unsignedBigInteger('stock_types_id');
            $table->foreign('stock_types_id')->references('stock_types_id')->on('stock_types');

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
        Schema::dropIfExists('subwallets');
    }
}
