<?php


namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class AlarmDTO extends DataTransferObject
{
    public int $application_id;
    public int $status;
}
