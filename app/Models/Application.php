<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    const DOWNTIME_TOLERANCE = 5;
    const ACTIVE = 1;


    /**
     * @param string $appName
     * @return bool
     */
    public function exists(string $appName): bool
    {
        $app = Application::where('name', trim($appName))->where('active', '1')->first();
        return (bool) $app;
    }

    /**
     * @return bool
     */
    public function logToleranceAcceptable($log): bool
    {
        $receivedDate = new Carbon($log->received_date);
        $downtime = (Carbon::now())->subMinutes(self::DOWNTIME_TOLERANCE);
        return $receivedDate > $downtime;

    }
}
