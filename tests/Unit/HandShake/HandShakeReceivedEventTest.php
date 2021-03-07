<?php

namespace Tests\Unit\HandShake;

use App\Events\HandShakeReceivedEvent;
use Carbon\Carbon;
use Tests\TestCase;

class HandShakeReceivedEventTest extends TestCase
{

    /**
     * @test
     */
    public function record_a_hand_shake_in_logs()
    {
        $handShakeEvent = new HandShakeReceivedEvent('Test', Carbon::now());
        $this->assertEquals('Test', $handShakeEvent->appName);
    }
}
