<?php

namespace App\Console\Commands\Exchanges\B3;

use App\Services\Exchanges\B3\StocksService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportStocksCommand extends Command
{
    protected $signature = 'exchanges:b3-import-stocks';

    protected $description = 'Import all the stock of the exchange.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(StocksService $stocksService): int
    {
        $stocks = Storage::disk('public')->path('exchanges/b3/stocks.csv');
        $stocksService->importStocks($stocks);
        return 0;
    }
}
