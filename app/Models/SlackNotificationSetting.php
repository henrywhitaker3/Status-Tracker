<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlackNotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = ['webhook_url'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Return the service the check is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
