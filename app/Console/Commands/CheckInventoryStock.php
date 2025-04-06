<?php
namespace App\Console\Commands;

use App\Jobs\CheckInventoryStock as CheckInventoryStockJob;
use Illuminate\Console\Command;

class CheckInventoryStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-inventory-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CheckInventoryStockJob::dispatch();
    }
}
