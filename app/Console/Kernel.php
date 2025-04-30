<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\AutoSaveReadingProgress::class
    ];

    protected function schedule(Schedule $schedule)
    {
        // ... existing code ...

        // Auto-save reading progress every 5 minutes
        $schedule->command('reading:auto-save')
                ->everyFiveMinutes()
                ->withoutOverlapping();
    }
}