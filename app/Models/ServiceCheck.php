<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'up',
        'response_code',
        'response_body',
    ];

    protected $casts = [
        'response_code' => 'integer',
        'up' => 'boolean',
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
}
