<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HandShakeReceivedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $appName;
    /**
     * @var Carbon
     */
    public $timestamp;

    /**
     * Create a new event instance.
     *
     * @param string $appName
     * @param Carbon $timestamp
     */
    public function __construct(string $appName, Carbon $timestamp)
    {
        $this->appName = $appName;
        $this->timestamp = $timestamp;
    }
}
