<?php

namespace App\Models;

use App\DTO\AlarmDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarms extends Model
{
    use HasFactory;
    const STATUS_OPEN = 1;

    /**
     * @param AlarmDTO $alarm
     */
    public function record(AlarmDTO $alarm)
    {
        $newAlarm = new Alarms();
        $newAlarm->application_id = $alarm->application_id;
        $newAlarm->started_at = Carbon::now();
        $newAlarm->status = $alarm->status;
        $newAlarm->save();
    }

    /**
     * @param int $applicationId
     * @return bool
     */
    public function exists(int $applicationId) : bool
    {
        $exists = $this->where('application_id', $applicationId)
            ->where('status', self::STATUS_OPEN)
            ->first();

        return (bool) $exists;
    }
}
