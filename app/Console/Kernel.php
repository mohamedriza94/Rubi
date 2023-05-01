<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\Sub\PayrollController;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('command:deleteOTP')->everyMinute(); //auto delete OTP 10 mins after sending
        $schedule->call([PayrollController::class, 'setPayroll'])
                 ->monthlyOn(1, '00:00')
                 ->name('setPayroll')
                 ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
