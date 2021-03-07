<?php
declare(strict_types=1);

namespace App\DTO;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class ApplicationHandShakeDTO
 * @package App\DTO
 */
class ApplicationHandShakeDTO extends DataTransferObject
{
    public Carbon $timestamp;
    public string $appName;
}
