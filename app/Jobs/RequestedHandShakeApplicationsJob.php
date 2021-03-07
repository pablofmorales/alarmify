<?php

namespace App\Jobs;

use App\Events\HandShakeReceivedEvent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RequestedHandShakeApplicationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $appName;
    /**
     * @var Carbon
     */
    private $timestamp;

    /**
     * Create a new job instance.
     *
     * @param string $appName
     * @param Carbon $timestamp
     */
    public function __construct(string $appName, Carbon $timestamp)
    {
        $this->appName = $appName;
        $this->timestamp = $timestamp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Message Processed for ' . $this->appName);
        HandShakeReceivedEvent::dispatch($this->appName, $this->timestamp);
    }
}
