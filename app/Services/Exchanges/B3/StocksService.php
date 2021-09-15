<?php

namespace App\Services\Exchanges\B3;

use App\Models\Exchanges\B3\StocksModel;
use App\Services\Utils\CsvReader;

class StocksService
{
    private const ACAO          = 1;
    private const ETF           = 2;
    private const FII           = 3;
    private const TICKER_FII_B3 = '11';
    private const TICKER_ETF_B3 = '34';

    public function importStocks(string $stocks)
    {
        $csvReader = new CsvReader($stocks);
        $content = $csvReader->readAllFile();

        foreach ($content as $line) {
            if ($line) {
                $stockType = $this->checkStockType($line[0]);
                StocksModel::updateOrCreate(['name' => $line[0], 'stock_types_id' => $stockType],[]);
            }
        }
    }

    public function checkStockType(string $stock): int
    {
        switch ($stock) {
            case strpos($stock, self::TICKER_FII_B3) == true;
                return self::FII;
            case strpos($stock, self::TICKER_ETF_B3) == true;
                return self::ETF;
            default:
                return self::ACAO;
        }
    }
}
