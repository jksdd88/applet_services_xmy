<?php

namespace App\Console\Commands;

use App\Services\LiveService;
use Illuminate\Console\Command;

class LiveRecordDel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LiveRecordDel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Record Delete';

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
        $liveService->deleteRecordConsole();
    }
}
