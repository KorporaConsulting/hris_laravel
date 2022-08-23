<?php

namespace App\Console;

use App\Jobs\KehadiranChecking;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->exec('curl http://localhost:8000/check-alpha')->weekdays()->at('17:00');
        $schedule->exec('curl http://localhost:8000/cuti-bulanan')->monthly();
        $schedule->command('auth:clear-resets')->everyFifteenMinutes();
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
