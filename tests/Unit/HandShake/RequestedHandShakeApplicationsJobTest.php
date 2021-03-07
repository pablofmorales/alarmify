<?php
declare(strict_types=1);
namespace Tests\Unit\HandShake;

use App\Events\HandShakeReceivedEvent;
use App\Jobs\RequestedHandShakeApplicationsJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RequestedHandShakeApplicationsJobTest extends TestCase
{

    /**
     * @test
     */
    public function acceptNewRequestsFromApplications()
    {
        $appName = 'TestDummy';
        $timestamp = Carbon::now();
        $job = new RequestedHandShakeApplicationsJob($appName, $timestamp);

        $this->assertInstanceOf(RequestedHandShakeApplicationsJob::class, $job);
    }


    /**
     * @test
     */
    public function GivenAnApplicationIShouldSaveIt()
    {
        Event::fake();
        $appName = 'TestDummy';
        $timestamp = Carbon::now();
        $job = new RequestedHandShakeApplicationsJob($appName, $timestamp);

        $job->handle();
        Event::assertDispatched(HandShakeReceivedEvent::class);
    }
}
