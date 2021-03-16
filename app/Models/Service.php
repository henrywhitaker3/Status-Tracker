<?php

namespace App\Models;

use App\Actions\CheckServiceAction;
use App\Casts\CheckTypeCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Service extends Model
{
    use HasFactory;
    use HasEagerLimit;

    protected $fillable = [
        'name',
        'check_url',
        'access_url',
        'type',
    ];

    protected $casts = [
        'status' => 'boolean',
        'enabled' => 'boolean',
        'type' => CheckTypeCast::class,
    ];

    // TODO: Figure out this thing
    // public function scopeWithUptimePercentage($query)
    // {
    //     return $query->addSelect([
    //         'uptime_percentage' => ServiceCheck::query()
    //             ->selectRaw('100.0 * CASE COUNT(*)')
    //     ]);
    // }

    public function scopeEnabled($query, $enabled = true)
    {
        return $query->where('enabled', $enabled);
    }

    public function scopeWithTotalChecks($query)
    {
        return $query->addSelect([
            'total_checks' => ServiceCheck::selectRaw('count(*)')
                ->whereColumn('services.id', 'service_checks.service_id'),
        ]);
    }

    /**
     * Get the total time a service has had it's current
     * status.
     *
     * @param boolean $humanReadable
     * @return \Carbon\CarbonInterval|string
     */
    public function statusDuration($humanReadable = false)
    {
        $since = $this->checks()->latest()->first()->created_at;

        $diff = Carbon::now()->diffAsCarbonInterval($since);

        return $humanReadable ? $diff->forHumans() : $diff;
    }

    /**
     * Perform a status check for the service.
     *
     * @return ServiceCheck
     */
    public function check(): ServiceCheck
    {
        return run(CheckServiceAction::class, $this);
    }

    /**
     * Return the checks for this service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checks()
    {
        return $this->hasMany(ServiceCheck::class);
    }

    /**
     * Return the checks for this service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recentChecks()
    {
        return $this->hasMany(ServiceCheck::class)->latest();
    }

    public static function createRules()
    {
        return [
            'name' => ['required', 'string'],
            'access_url' => ['required', 'string'],
            'check_url' => ['required', 'string'],
            'enabled' => ['required', 'boolean'],
            'type' => ['required', 'in:' . implode(',', self::types())]
        ];
    }

    /**
     * Return array of supported types.
     *
     * @return array
     */
    public static function types(): array
    {
        return [
            1 => 'http',
            2 => 'ping',
        ];
    }

    /**
     * Determines whether slack notifications should be sent.
     *
     * @return bool
     */
    public function shouldSendSlackNotification(): bool
    {
        if (Setting::retrieve('Slack webhook', true) === "") {
            return false;
        }

        return true;
    }

    /**
     * Determines whether discord notifications should be sent.
     *
     * @return bool
     */
    public function shouldSendDiscordNotification(): bool
    {
        if (Setting::retrieve('Discord webhook', true) === "") {
            return false;
        }

        return true;
    }
}
