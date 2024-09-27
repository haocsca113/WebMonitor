<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Website;
use App\Jobs\AttackDetectedJob;
use App\Http\Controllers\AttackDetectedController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Dispatch job mỗi 1 phút
        $schedule->call(function () {
            $websites = Website::all();
            foreach ($websites as $website) {
                AttackDetectedJob::dispatch($website);
                // App\Jobs\AttackDetectedJob::dispatch($website);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
