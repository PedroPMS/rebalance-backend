<?php

namespace App\Console\Commands\Exchanges\B3;

use App\Services\Exchanges\B3\StocksService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateStocksCommand extends Command
{
    protected $signature = 'exchanges:b3-update-stocks';

    protected $description = 'Update all the stocks based on Yahoo Finance.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(StocksService $stocksService): int
    {
        $stocksService->updateStocks();
        return 0;
    }
}
