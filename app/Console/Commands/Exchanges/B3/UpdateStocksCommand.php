<?php

namespace App\Console\Commands\Exchanges\B3;

use App\Services\Exchanges\B3\UpdateStocksService;
use Illuminate\Console\Command;

class UpdateStocksCommand extends Command
{
    protected $signature = 'exchanges:b3-update-stocks {stockType}';

    protected $description = 'Update all the stocks based on Yahoo Finance.';

    private UpdateStocksService $stocksService;

    public function __construct(UpdateStocksService $stocksService)
    {
        parent::__construct();
        $this->stocksService = $stocksService;
    }

    public function handle(): int
    {
        $processStartedAt = now();
        $progressBar = null;

        $this->stocksService->eventGetStocks = function ($stocks) use (&$progressBar) {
            $progressBar = $this->output->createProgressBar(count($stocks));
            $progressBar->start();
        };

        $this->stocksService->eventUpdateStock = function () use (&$progressBar) {
            $progressBar->advance();
        };

        $this->stocksService->eventEnd = function () use (&$progressBar) {
            $progressBar->finish();
        };

        $this->stocksService->updateStocks($this->argument('stockType'));
        $this->newLine();
        $this->info(__('Ends').': '. now()->diffForHumans($processStartedAt));

        return 0;
    }
}
