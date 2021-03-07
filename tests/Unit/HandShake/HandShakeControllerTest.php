<?php

namespace Tests\Unit\HandShake;

use App\Actions\ConfirmApplicationHandShakeAction;
use App\Exceptions\NotFoundApplicationException;
use App\Http\Controllers\HandShakeController;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Tests\TestCase;

class HandShakeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function AValidApplicationShouldReturnASuccessMessage()
    {
        $applicationAction = \Mockery::mock(ConfirmApplicationHandShakeAction::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->once();
        });
        $handShake = new HandShakeController($applicationAction);
        $response = $handShake->index('dummyTest');
        $this->assertEquals(Response::HTTP_ACCEPTED, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function ANonExistentApplicationWantToHandShakeAndFail()
    {
        $applicationAction = \Mockery::mock(ConfirmApplicationHandShakeAction::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->andThrow(new NotFoundApplicationException())
                ->once();
        });
        $handShake = new HandShakeController($applicationAction);
        $response = $handShake->index('notExistentAppTest');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
