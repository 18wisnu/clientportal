<?php

namespace App\Console\Commands;

use App\Services\MixRadiusService;
use Illuminate\Console\Command;

class SyncCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mixradius:sync-customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync customers from Mixradiusku API';

    /**
     * Execute the console command.
     */
    public function handle(MixRadiusService $service)
    {
        $this->info('Starting customer synchronization...');

        $count = $service->syncCustomers();

        if ($count > 0) {
            $this->success("Successfully synced {$count} customers.");
        } else {
            $this->warn('No customers synced. Check logs for details.');
        }
    }
}
