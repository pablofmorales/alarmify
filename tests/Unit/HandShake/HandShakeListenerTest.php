<?php

namespace Tests\Unit\HandShake;

use App\Events\HandShakeReceivedEvent;
use App\Listeners\HandShakeListener;
use App\Repositories\ApplicationsLogRepository;
use Carbon\Carbon;
use Tests\TestCase;

class HandShakeListenerTest extends TestCase
{

    /**
     * @test
     */
    public function given_a_hand_shake_event_i_should_record_it()
    {
        $applicationMock = \Mockery::mock(ApplicationsLogRepository::class);
        $applicationMock->shouldReceive('recordHandShake')
            ->once();

        $handShake = new HandShakeReceivedEvent('Test', Carbon::now());
        $listener = new HandShakeListener($applicationMock);

        $this->assertTrue($listener->handle($handShake));
    }
}
