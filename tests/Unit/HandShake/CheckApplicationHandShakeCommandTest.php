<?php

namespace Tests\Unit\HandShake;

use App\Actions\AnalyseDowntimeInApplicationsAction;
use App\Console\Commands\CheckApplicationHandShakesCommand;
use Tests\TestCase;

class CheckApplicationHandShakeCommandTest extends TestCase
{

    /**
     * @test
     */
    public function executing_the_cli_i_should_trigger_the_handshake_validation_process()
    {
        $command = new CheckApplicationHandShakesCommand();

        $action = \Mockery::mock(AnalyseDowntimeInApplicationsAction::class);
        $action->shouldReceive('execute')->once();

        $command->handle($action);
    }
}
