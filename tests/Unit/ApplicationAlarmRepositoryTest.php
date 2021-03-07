<?php
namespace Tests\Unit;

use App\Models\Alarms;
use App\Repositories\ApplicationsAlarmRepository;
use Tests\TestCase;

class ApplicationAlarmRepositoryTest extends TestCase
{


    /**
     * @test
     * @dataProvider newBrokenApplicationProvider
     * @param $alarms
     */
    public function given_a_broken_application_i_should_record_an_alarm($alarms)
    {
        $repository = new ApplicationsAlarmRepository($alarms);
        $repository->recordAlarm(30);
    }

    /**
     * @return array[]
     */
    public function newBrokenApplicationProvider(): array
    {
        $alarms = \Mockery::mock(Alarms::class);

        $alarms->shouldReceive('record')
            ->once();

        $alarms->shouldReceive('exists')
            ->andReturn(false);

        return [
            [
                $alarms
            ]
        ];
    }
}
