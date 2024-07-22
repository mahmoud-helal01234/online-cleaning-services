<?php

namespace App\Console\Commands;

use App\Http\Services\Orders\DriverLocationsService;
use App\Http\Services\Orders\OrderLocationsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteLocationsDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locations:deleteLocationsDaily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Log::info("Cron is working fine!");

        $driverLocationsService = new DriverLocationsService();
        $driverLocationsService->deleteAll();
        $orderLocationsService = new OrderLocationsService();
        $orderLocationsService->deleteAll();
        return Command::SUCCESS;
    }
}
