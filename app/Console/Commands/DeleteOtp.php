<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeleteOtp extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'command:deleteOTP';
    
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Command description';
    
    /**
    * Execute the console command.
    *
    * @return int
    */
    public function handle()
    {
        $expiredAt = Carbon::now()->subMinutes(10);
        
        DB::table('password_resets')
        ->where('created_at', '<', $expiredAt)
        ->delete();
    }
}
