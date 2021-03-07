<?php

namespace Tests\Unit;

use App\DTO\ApplicationHandShakeDTO;
use App\Models\Application;
use App\Models\ApplicationHandShakeLog;
use App\Repositories\ApplicationsLogRepository;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

class ApplicationLogRepositoryTest extends TestCase
{

    /**
     * @param $applicationModel
     * @param $logModel
     * @dataProvider brokenListProvider
     *
     * @test
     */
    public function check_broken_applications_that_did_not_responded($applicationModel, $logModel)
    {
        $repository = new ApplicationsLogRepository($applicationModel, $logModel);
        $broken = $repository->fetchBrokenApplications();
        $this->assertCount(1, $broken);
    }

    /**
     * @test
     * @dataProvider validApplicationHandShake
     * @param $applicationModel
     * @param $logModel
     */
    public function given_a_valid_application_i_should_store_in_db($applicationModel, $logModel)
    {
        $dto = new ApplicationHandShakeDTO([
            'appName' => 'test',
            'timestamp' => Carbon::now(),
        ]);

        $repository = new ApplicationsLogRepository($applicationModel, $logModel);
        $repository->recordHandShake($dto);

        $logModel->shouldHaveReceived()
            ->save();
        $this->assertTrue(true);
    }

    /**
     * @test
     * @dataProvider existentHandShake
     * @param $applicationModel
     * @param $logModel
     */
    public function given_an_existent_log_i_should_not_record_it($applicationModel, $logModel)
    {
        $dto = new ApplicationHandShakeDTO([
            'appName' => 'test',
            'timestamp' => Carbon::now(),
        ]);

        $repository = new ApplicationsLogRepository($applicationModel, $logModel);
        $response = $repository->recordHandShake($dto);

        $this->assertNull($response);
    }

    /**
     * @test
     * @dataProvider invalidApplicationHandShake
     * @param $applicationModel
     * @param $logModel
     */
    public function given_an_invalid_application_it_should_fail($applicationModel, $logModel)
    {
        $dto = new ApplicationHandShakeDTO([
            'appName' => 'test',
            'timestamp' => Carbon::now(),
        ]);

        $repository = new ApplicationsLogRepository($applicationModel, $logModel);
        $response = $repository->recordHandShake($dto);

        $this->assertNull($response);
    }

    /**
     * @return array[]
     */
    public function validApplicationHandShake(): array
    {
        $applicationModel = \Mockery::mock(Application::class);

        $applicationModel->shouldReceive('where')
                ->andReturnSelf();

        $applicationModel->shouldReceive('firstOrFail')
                ->andReturn((object) ['id' => 3]);

        $logModel = \Mockery::mock(ApplicationHandShakeLog::class);
        $logModel->shouldReceive('where')
                ->andReturnSelf();

        $logModel->shouldReceive('setAttribute')
            ->andReturnSelf();

        $logModel->shouldReceive('save')
            ->andReturnSelf();

        $logModel->shouldReceive('first')
                ->andReturn(null);

        return [
            [
                'applicationModel' => $applicationModel,
                'logModel' => $logModel,
            ]
        ];
    }

    /**
     *
     * @return array
     */
    public function existentHandShake(): array
    {
        $applicationModel = \Mockery::mock(Application::class);

        $applicationModel->shouldReceive('where')
            ->andReturnSelf();

        $applicationModel->shouldReceive('firstOrFail')
            ->andReturn((object) ['id' => 3]);

        $logModel = \Mockery::spy(ApplicationHandShakeLog::class);
        $logModel->shouldReceive('where')
            ->andReturnSelf();

        $logModel->shouldReceive('setAttribute')
            ->andReturnSelf();

        $logModel->shouldReceive('first')
            ->andReturn((object) ['test']);

        return [
            [
                'applicationModel' => $applicationModel,
                'logModel' => $logModel,
            ]
        ];
    }

    /**
     *
     * @return array
     */
    public function invalidApplicationHandShake(): array
    {
        $applicationModel = \Mockery::mock(Application::class);

        $applicationModel->shouldReceive('where')
                ->andReturnSelf();
        $applicationModel->shouldReceive('firstOrFail')
                ->andThrow(new ModelNotFoundException());

        $logModel = \Mockery::mock(ApplicationHandShakeLog::class);

        return [
            [
                'applicationModel' => $applicationModel,
                'logModel' => $logModel,
            ]
        ];
    }

    public function brokenListProvider(): array
    {
        $applicationFake =  [
            (object) ['id' => 1, 'name' => 'testDummy']
        ];

        $applicationModel = \Mockery::mock(Application::class);

        $applicationModel->shouldReceive('logToleranceAcceptable')
            ->andReturn(false);


        $applicationModel->shouldReceive('where')
            ->andReturnSelf();
        $applicationModel->shouldReceive('get')
            ->andReturn((object) $applicationFake);

        $logModel = \Mockery::mock(ApplicationHandShakeLog::class);

        $logModel->shouldReceive('where')
            ->andReturnSelf();

        $logModel->shouldReceive('get')
            ->andReturn($applicationFake);

        return [
            [
                'applicationModel' => $applicationModel,
                'logModel' => $logModel,
            ]
        ];
    }
}
