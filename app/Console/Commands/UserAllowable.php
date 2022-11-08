<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UserAllowable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:allowable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengguna sudah bisa mengakses website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::banned()->where('banned_at', '<', Carbon::now())->update([
            'status' => 'allowable',
            'banned_at' => null,
        ]);
    }
}
