<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationHandShakeLog extends Model
{
    use HasFactory;

    protected $table = 'application_hand_shakes_logs';

    protected $fillable = [
        'application_id',
        'timestamp',
    ];

    public function setTimestampAttribute($value)
    {
        $this->attributes['received_date'] = strtolower($value);
    }
}
