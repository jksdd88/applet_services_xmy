<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LiveService;

class LiveSwitch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LiveSwitch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Switch Channel';

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
    public function handle(LiveService $liveService)
    {
        $liveService->openConsole();
        $liveService->closeConsole();
    }
}
