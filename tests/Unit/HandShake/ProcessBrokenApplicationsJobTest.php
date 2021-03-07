<?php

namespace Tests\Unit\HandShake;

use App\Jobs\ProcessBrokenApplicationsJob;
use App\Repositories\ApplicationsAlarmRepository;
use Mockery\MockInterface;
use Tests\TestCase;

class ProcessBrokenApplicationsJobTest extends TestCase
{

    /**
     * @test
     */
    public function given_a_list_of_broken_application_i_should_prepare_notifications()
    {
        $brokenApplications = [
            ['id' => 1],
            ['id' => 57],
            ['id' => 83],
        ];

        $applicationRepository = \Mockery::mock(
            ApplicationsAlarmRepository::class,
            function (MockInterface $mock) use ($brokenApplications) {
                $mock->shouldReceive('recordAlarm')
                    ->times(count($brokenApplications));
            }
        );

        $job = new ProcessBrokenApplicationsJob($brokenApplications);
        $job->handle($applicationRepository);
    }
}
