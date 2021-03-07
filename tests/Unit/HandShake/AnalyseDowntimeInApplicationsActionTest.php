<?php

namespace Tests\Unit\HandShake;

use App\Actions\AnalyseDowntimeInApplicationsAction;
use App\Events\NoBrokenApplicationDetectedEvent;
use App\Jobs\ProcessBrokenApplicationsJob;
use App\Repositories\ApplicationsLogRepository;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Mockery\MockInterface;
use Tests\TestCase;

class AnalyseDowntimeInApplicationsActionTest extends TestCase
{

    /**
     * @test
     */
    public function process_latest_application_handshake_should_not_find_issues()
    {
        Event::fake();

        $repositoryMock = $this->mock(ApplicationsLogRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('fetchBrokenApplications')
                ->andReturn([])
                ->once();
        });
        $action = new AnalyseDowntimeInApplicationsAction($repositoryMock);
        $action->execute();
        Event::assertDispatched(NoBrokenApplicationDetectedEvent::class);
    }

    /**
     * @test
     */
    public function process_latest_application_handshake_shout_find_broken_ones()
    {
        Bus::fake();

        $repositoryMock = $this->mock(ApplicationsLogRepository::class, function (MockInterface $mock) {
            $mock->shouldReceive('fetchBrokenApplications')
                ->andReturn([
                    ['application_id' => 1],
                    ['application_id' => 57],
                    ['application_id' => 83],
                ])
                ->once();
        });
        $action = new AnalyseDowntimeInApplicationsAction($repositoryMock);
        $action->execute();


        Bus::assertDispatched(ProcessBrokenApplicationsJob::class);
    }
}
