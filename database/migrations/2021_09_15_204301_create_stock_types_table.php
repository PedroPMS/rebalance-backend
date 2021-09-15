<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTypesTable extends Migration
{
    public function up()
    {
        Schema::create('stock_types', function (Blueprint $table) {
            $table->id('stock_types_id');

            $table->string('stock_type');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_types');
    }
}
