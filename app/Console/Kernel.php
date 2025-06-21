<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define os comandos do aplicativo.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    /**
     * Define o agendamento de tarefas do aplicativo.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('report:daily-seller')->dailyAt('23:55');
        $schedule->command('report:daily-admin')->dailyAt('23:56');
    }
}
