<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class EmailCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verificationemail:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if user send many request to verify his email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('email_verified_code_times', '<>', null)->get();
        foreach ($users as $user) {
            $user->email_verified_code_times = null;
            $user->save();
        }
    }
}
