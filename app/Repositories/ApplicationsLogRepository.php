<?php
declare(strict_types=1);

namespace App\Repositories;

use App\DTO\ApplicationHandShakeDTO;
use App\Models\Application;
use App\Models\ApplicationHandShakeLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ApplicationsLogRepository
 * @package App\Repositories
 */
class ApplicationsLogRepository
{

    /**
     * @var Application
     */
    private Application $application;
    /**
     * @var ApplicationHandShakeLog
     */
    private ApplicationHandShakeLog $handShakeLog;

    /**
     * ApplicationsLogRepository constructor.
     * @param Application $application
     * @param ApplicationHandShakeLog $handShakeLog
     */
    public function __construct(Application $application, ApplicationHandShakeLog $handShakeLog)
    {
        $this->application = $application;
        $this->handShakeLog = $handShakeLog;
    }

    /**
     * @param ApplicationHandShakeDTO $dto
     */
    public function recordHandShake(ApplicationHandShakeDTO $dto): void
    {
        try {
            $app = $this->application->where('name', $dto->appName)->firstOrFail();

            if (! $this->exists($app, $dto)) {
                $this->saveHandShake($app, $dto);
            }
        } catch (ModelNotFoundException $e) {
        }
    }

    /**
     * @param $app
     * @param ApplicationHandShakeDTO $dto
     */
    private function saveHandShake($app, ApplicationHandShakeDTO $dto): void
    {
        $this->handShakeLog->application_id = $app->id;
        $this->handShakeLog->received_date = $dto->timestamp;
        $this->handShakeLog->save();
    }

    /**
     * @param $app
     * @param ApplicationHandShakeDTO $dto
     * @return mixed
     */
    private function exists($app, ApplicationHandShakeDTO $dto)
    {
        return $this->handShakeLog->where('application_id', $app->id)
            ->where('received_date', $dto->timestamp)
            ->first();
    }

    /**
     * @return array
     */
    public function fetchBrokenApplications(): array
    {
        $failingApplications = [];

        $applications = $this->application->where('active', Application::ACTIVE)->get();

        foreach ($applications as $app) {
            $logs = $this->latestLogs($app->id);
            if ($this->isApplicationBroken($logs)) {
                $failingApplications[] = $app;
            }
        }

        return $failingApplications;

    }

    /**
     * @param $logs
     * @return bool
     */
    private function isApplicationBroken($logs) : bool
    {
        foreach($logs as $log) {
            if ($this->application->logToleranceAcceptable($log)) {
                return false;
            }
        }
        return true;
    }

    private function latestLogs(int $applicationId) : array
    {
        $timeScope = (Carbon::now())->subMinutes(Application::DOWNTIME_TOLERANCE);
        return $this->handShakeLog->where('application_id', $applicationId)
            ->where('received_date', '>=', $timeScope)
            ->get();

    }
}
