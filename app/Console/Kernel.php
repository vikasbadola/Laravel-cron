<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command('inspire')->hourly();
    }
    
    /**
     * Custom command to schedule for short intervals
     * 
     * @param \Spatie\ShortSchedule\ShortSchedule $shortSchedule
     */
    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule) {
        // this artisan command will run every 10 seconds
        $shortSchedule->command('fetch:data')->everySecond(10);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
