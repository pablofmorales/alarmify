<?php

namespace Tests\Unit\HandShake;

use App\Actions\ConfirmApplicationHandShakeAction;
use App\Events\HandShakeReceivedEvent;
use App\Exceptions\NotFoundApplicationException;
use App\Models\Application;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Mockery;

use Tests\TestCase;

class ConfirmApplicationHandShakeActionTest extends TestCase
{

    /**
     *
     * @test
     * @throws NotFoundApplicationException
     */
    public function BasedOnAnExistentAppIConfirmTheHandShake()
    {
        $appName = 'testDummy';

        Event::fake(HandShakeReceivedEvent::class);

        $applicationModel = Mockery::mock(Application::class, function (MockInterface $mock) {
            $mock->shouldReceive('exists')
                ->andReturn(true)
                ->once();
        });
        $confirmation = new ConfirmApplicationHandShakeAction($applicationModel);

        $confirmation->execute($appName);

        Event::assertDispatched(HandShakeReceivedEvent::class);
        //if we don't get exception the execution was success
    }

    /**
     * @test
     */
    public function ANonExistentApplicationWantToConfirmHandShakeAndFail()
    {
        $appName = 'testDummy';

        $applicationModel = Mockery::mock(Application::class, function (MockInterface $mock) {
            $mock->shouldReceive('exists')
                ->andReturn(false)
                ->once();
        });
        $this->expectException(NotFoundApplicationException::class);

        $confirmation = new ConfirmApplicationHandShakeAction($applicationModel);
        $confirmation->execute($appName);
    }
}
