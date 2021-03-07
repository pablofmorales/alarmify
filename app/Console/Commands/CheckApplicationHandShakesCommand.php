<?php

namespace App\Console\Commands;

use App\Actions\AnalyseDowntimeInApplicationsAction;
use Illuminate\Console\Command;

class CheckApplicationHandShakesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:handshake-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the latest handshake and analyse if we require to send an Alarm';

    /**
     * Execute the console command.
     *
     * @param AnalyseDowntimeInApplicationsAction $analyseDowntimeInApplicationsAction
     * @return int
     */
    public function handle(AnalyseDowntimeInApplicationsAction $analyseDowntimeInApplicationsAction): int
    {
        $analyseDowntimeInApplicationsAction->execute();
        return 0;
    }
}
