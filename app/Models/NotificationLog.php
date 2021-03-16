<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'type',
        'service_check_id',
        'service_id',
    ];

    public function serviceCheck()
    {
        return $this->belongsTo(ServiceCheck::class);
    }
}
