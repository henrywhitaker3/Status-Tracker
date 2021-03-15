<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordNotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = ['webhook_url'];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
