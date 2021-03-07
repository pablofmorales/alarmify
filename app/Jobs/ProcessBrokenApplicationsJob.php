<?php

namespace App\Jobs;

use App\Repositories\ApplicationsAlarmRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBrokenApplicationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $brokenApplications;

    /**
     * Create a new job instance.
     *
     * @param array $brokenApplications
     */
    public function __construct(array $brokenApplications)
    {
        $this->brokenApplications = $brokenApplications;
    }

    /**
     * Execute the job.
     *
     * @param ApplicationsAlarmRepository $applicationsRepository
     * @return void
     */
    public function handle(ApplicationsAlarmRepository $applicationsRepository)
    {
        foreach ($this->brokenApplications as $app) {
            $applicationsRepository->recordAlarm($app['id']);
        }
    }
}
