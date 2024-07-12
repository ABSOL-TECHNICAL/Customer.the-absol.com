<?php
 
namespace App\Console;
 
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Helpers\CustomerSync;
use Illuminate\Support\Facades\Log;
 
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            try {
                Log::info('Starting scheduled customer data sync.');
                $sync = new CustomerSync();
                $sync->syncCustomers();
                Log::info('Scheduled customer data sync completed successfully.');
            } catch (\Exception $e) {
                Log::error('Error during scheduled customer data sync:', ['exception' => $e->getMessage()]);
            }
        })->everyFiveMinutes();
    }
 
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
 
        require base_path('routes/console.php');
    }
}