<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Setting extends Model
{
    use HasFactory;

    public static array $settings = [];

    protected $fillable = [
        'name',
        'value',
        'cast',
        'category',
        'info',
    ];

    public static function getAll()
    {
        $settings = Setting::get();

        foreach ($settings as $setting) {
            self::$settings[$setting->name] = $setting;
        }

        return self::$settings;
    }

    /**
     * Retrieve a setting.
     *
     * @param string $name  The name of the setting
     * @param boolean $value    If true, just returns the casted value not the whole model
     * @return mixed
     */
    public static function retrieve(string $name, bool $value = false)
    {
        if (!array_key_exists($name, self::$settings)) {
            $setting = Setting::where('name', $name)->first();

            if ($setting === null) {
                throw new ModelNotFoundException('Setting ' . $name . ' could not be found');
            }

            self::$settings[$name] = $setting;
        } else {
            $setting = self::$settings[$name];
        }

        if ($value) {
            $val = $setting->value;
            settype($val, $setting->cast);
            return $val;
        }

        return $setting;
    }
}
