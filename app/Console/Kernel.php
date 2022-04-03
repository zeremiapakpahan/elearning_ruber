<?php

namespace App\Console;

use \App\Penugasan as Penugasan;
use \App\Quiz as Quiz;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {
            $penugasan = Penugasan::get();

            foreach ($penugasan as $penugasan) {
                if (date('Y-m-d h:m') >= $penugasan->batas) {
                    $penugasan->status = "Tutup";
                    $penugasan->save();
                }
            }

            $quiz = Quiz::get();

            foreach ($quiz as $quiz) {
                if (date('Y-m-d h:m') >= $quiz->batas) {
                    $quiz->status = "Tutup";
                    $quiz->save();
                }
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
