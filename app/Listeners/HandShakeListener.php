<?php

namespace App\Listeners;

use App\DTO\ApplicationHandShakeDTO;
use App\Events\HandShakeReceivedEvent;
use App\Repositories\ApplicationsLogRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandShakeListener
{
    /**
     * @var ApplicationsLogRepository
     */
    private ApplicationsLogRepository $applicationsRepository;

    /**
     * HandShakeListener constructor.
     * @param ApplicationsLogRepository $applicationsRepository
     */
    public function __construct(ApplicationsLogRepository $applicationsRepository)
    {
        $this->applicationsRepository = $applicationsRepository;
    }

    /**
     * Handle the event.
     *
     * @param HandShakeReceivedEvent $handShake
     * @return bool
     */
    public function handle(HandShakeReceivedEvent $handShake): bool
    {
        $handShakeDto = new ApplicationHandShakeDTO([
            'appName' => $handShake->appName,
            'timestamp' => $handShake->timestamp,
        ]);

        $this->applicationsRepository->recordHandShake($handShakeDto);

        return true;
    }
}
