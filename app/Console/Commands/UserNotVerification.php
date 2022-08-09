<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UserNotVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:notverification';

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
        $now = Carbon::now();
        $week = $now->endOfWeek(Carbon::TUESDAY);

        $users = User::where('email_verified_at', null)
            ->where('status', 'notverification')
            ->where('created_at', '>=', $week)
            ->get();
        $path = "vendor/dashboard/image/picture-profiles/";

        foreach ($users as $user) {
            if (File::exists($path . $user->user_image)) {
                File::delete($path . $user->user_image);
            }
            $user->comments()->delete();
            $user->removeRole($user->roles->first());
            $user->delete();
        }
    }
}
