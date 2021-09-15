<?php

use App\Models\Exchanges\B3\StockTypesModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateStockTypesRegistries extends Migration
{
    public function up()
    {
        StockTypesModel::create(['stock_type' => 'Ação']);
        StockTypesModel::create(['stock_type' => 'ETF']);
        StockTypesModel::create(['stock_type' => 'Fii']);
    }

    public function down()
    {
        StockTypesModel::truncate();
    }
}
