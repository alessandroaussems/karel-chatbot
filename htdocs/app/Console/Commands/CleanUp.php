<?php

namespace App\Console\Commands;

use App\Livechat;
use App\Session;
use Illuminate\Console\Command;

class CleanUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all sessions from database';

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
     * @return mixed
     */
    public function handle()
    {
        Session::query()->delete();
    }
}
