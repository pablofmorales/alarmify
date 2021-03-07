<?php
declare(strict_types=1);

namespace App\Actions;

use App\Events\NoBrokenApplicationDetectedEvent;
use App\Jobs\ProcessBrokenApplicationsJob;
use App\Repositories\ApplicationsLogRepository;

class AnalyseDowntimeInApplicationsAction
{
    /**
     * @var ApplicationsLogRepository
     */
    private ApplicationsLogRepository $applicationsRepository;

    /**
     * AnalyseDowntimeInApplicationsAction constructor.
     * @param ApplicationsLogRepository $applicationsRepository
     */
    public function __construct(ApplicationsLogRepository $applicationsRepository)
    {
        $this->applicationsRepository = $applicationsRepository;
    }

    public function execute()
    {
        $brokenApplications  = $this->applicationsRepository->fetchBrokenApplications();

        if (empty($brokenApplications)) {
            NoBrokenApplicationDetectedEvent::dispatch();
        } else {
            ProcessBrokenApplicationsJob::dispatch($brokenApplications);
        }
    }
}
