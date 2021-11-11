<?php

namespace App\Services\Exchanges\B3;

use App\Models\Exchanges\B3\StocksModel;
use App\Services\Utils\YahooFinanceScrapping;
use Closure;

class UpdateStocksService
{
    public ?Closure $eventGetStocks = null;
    public ?Closure $eventUpdateStock = null;
    public ?Closure $eventEnd = null;
    private YahooFinanceScrapping $scrapping;

    public function __construct(YahooFinanceScrapping $scrapping)
    {
        $this->scrapping = $scrapping;
    }

    public function updateStocks(int $stockType)
    {
        $stocks = StocksModel::where('stock_types_id', $stockType)->get();

        if (is_callable($this->eventGetStocks)) {
            $eventGetStocks = $this->eventGetStocks;
            $eventGetStocks($stocks);
        }

        foreach ($stocks as $stock) {
            $this->updateSingleStock($stock);
            if (is_callable($this->eventUpdateStock)) {
                $eventUpdateStock = $this->eventUpdateStock;
                $eventUpdateStock();
            }
        }

        if (is_callable($this->eventEnd)) {
            $eventEnd = $this->eventEnd;
            $eventEnd();
        }
    }

    private function updateSingleStock(StocksModel $stock)
    {
        [$stockPrice, $variationValue, $variationPerc] = $this->scrapping->getStockInfo($stock->name);
        $stock->update([
            'actual_price'   => $stockPrice,
            'variation'      => $variationValue,
            'perc_variation' => $variationPerc,
            'previous_close' => $stockPrice + $variationValue,
        ]);
    }
}
