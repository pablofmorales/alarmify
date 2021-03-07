<?php
declare(strict_types=1);

namespace App\Repositories;

use App\DTO\AlarmDTO;
use App\Models\Alarms;

class ApplicationsAlarmRepository
{
    /**
     * @var Alarms
     */
    private Alarms $alarms;

    /**
     * ApplicationsAlarmRepository constructor.
     * @param Alarms $alarms
     */
    public function __construct(Alarms $alarms)
    {
        $this->alarms = $alarms;
    }

    /**
     * @param int $applicationId
     * @return void
     */
    public function recordAlarm(int $applicationId) : void
    {
        if (! $this->alarms->exists($applicationId)) {
            $alarmDTO = new AlarmDTO([
                'application_id' => $applicationId,
                'status' => Alarms::STATUS_OPEN,
            ]);
            $this->alarms->record($alarmDTO);
        }
    }
}
