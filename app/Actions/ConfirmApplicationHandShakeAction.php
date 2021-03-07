<?php
declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\NotFoundApplicationException;
use App\Jobs\RequestedHandShakeApplicationsJob;
use App\Models\Application;
use Carbon\Carbon;

/**
 * Class ConfirmApplicationHandShakeAction
 * @package App\Actions
 */
class ConfirmApplicationHandShakeAction
{
    /**
     * @var Application
     */
    private $application;

    /**
     * ConfirmApplicationHandShakeAction constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param string $appName
     * @throws NotFoundApplicationException
     */
    public function execute(string $appName)
    {
        if (! $this->application->exists($appName)) {
            throw new NotFoundApplicationException(
                'The Application do not exists or is not active'
            );
        }

        $timestamp = Carbon::now();
        RequestedHandShakeApplicationsJob::dispatch($appName, $timestamp);
    }
}
