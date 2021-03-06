<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UserAnonymous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:anonymous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = User::where('provider', 'anonymous')->where('last_seen', '>=', Carbon::tomorrow())->delete();
        $path = "vendor/dashboard/image/picture-profiles/";
        if (File::exists($path . $user->user_image)) {
            File::delete($path . $user->user_image);
        }
        $user->comments()->delete();
        $user->removeRole($user->roles->first());
    }
}
