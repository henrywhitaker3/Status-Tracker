<?php

namespace App\Utils;

class Config
{
    public static function getConfig()
    {
        return [
            'app' => [
                'name' => config('app.name'),
            ],
            'monitor' => config('monitor'),
        ];
    }
}
