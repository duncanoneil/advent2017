<?php

namespace App\Console;

use App\Console\Commands;
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
        Commands\Day1Puzzle1::class,
        Commands\Day1Puzzle2::class,
        Commands\Day2Puzzle1::class,
        Commands\Day2Puzzle2::class,
        Commands\Day3Puzzle1::class,
        Commands\Day3Puzzle1a::class,
        Commands\Day3Puzzle2::class,
        Commands\Day4Puzzle1::class,
        Commands\Day4Puzzle2::class,
        Commands\Day5Puzzle1::class,
        Commands\Day5Puzzle2::class,
        Commands\Day6Puzzle1::class,
        Commands\Day6Puzzle2::class,
        Commands\Day7Puzzle1::class,
        Commands\Day7Puzzle2::class,
        Commands\Day8Puzzle1::class,
        Commands\Day8Puzzle2::class,
        Commands\Day9Puzzle1::class,
        Commands\Day10Puzzle1::class,
        Commands\Day10Puzzle2::class,
        Commands\Day11Puzzle1::class,
        Commands\Day11Puzzle2::class,
        Commands\Day12Puzzle1::class,
        Commands\Day12Puzzle2::class,
        Commands\Day13Puzzle1::class,
        Commands\Day13Puzzle2::class,
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
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
