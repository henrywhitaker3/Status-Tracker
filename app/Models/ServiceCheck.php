<?php

namespace App\Models;

use App\Casts\CheckTypeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class ServiceCheck extends Model
{
    use HasFactory;
    use HasEagerLimit;

    protected $fillable = [
        'up',
        'response_code',
        'response_body',
        'type',
    ];

    protected $casts = [
        'response_code' => 'integer',
        'up' => 'boolean',
        'type' => CheckTypeCast::class,
    ];

    public function scopeWhereFailed($query)
    {
        return $query->where('up', false);
    }

    /**
     * Return the service the check is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Return the notifications associated with the check
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
