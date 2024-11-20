<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $command;
    /**
     * Create a new job instance.
     */
    public function __construct($command=false)
    {
        $this->command = $command;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->command){
            Log::error("Job executing from command");
        }else{
            Log::warning("Manual Testing");
        }
        Log::info("This is test job instance");
        Log::debug("Running test");
        Log::debug("Finished test");
        return;
    }
}
