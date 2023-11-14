<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check package expired for every user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('package_id', '<>', null)->get();
        $date = Carbon::now()->toDateString();
        foreach ($users as $user) {
            if ($date >= $user->package_end_at) {
                $user->update(['package_id' => null, 'package_start_at' => null, 'package_end_at' => null]);
            }
        }
    }
}
