<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Database';

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
        $filename = "backup_" . Carbon::now()->format('d_m_Y') . ".sql";
        $path = "database/backup";
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password='" . env('DB_PASSWORD') ."' --host=" . env('DB_HOST') . " " . env("DB_DATABASE") . " > " . $path . '/' . $filename;
        exec($command);
    }
}
