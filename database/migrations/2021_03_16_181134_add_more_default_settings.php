<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreDefaultSettings extends Migration
{
    public array $settings = [
        [
            'name' => 'Data retention',
            'info' => 'How many days to keep service check history for.',
            'value' => 7,
            'cast' => 'int',
            'category' => 'general',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->settings as $setting) {
            Setting::create($setting);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->settings as $setting) {
            Setting::where('name', $setting['name'])->delete();
        }
    }
}
