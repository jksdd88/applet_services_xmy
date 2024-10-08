<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LiveService;

class LiveClosePublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LiveClosePublish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Close Publish';

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
        $liveService->closePublishConsole();
    }
}
