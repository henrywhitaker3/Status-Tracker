<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('info')->nullable();
            $table->string('value')->nullable();
            $table->string('category')->default('general');
            $table->string('cast');
            $table->timestamps();
        });

        $defaults = [
            [
                'name' => 'Slack webhook',
                'info' => 'A webhook to send slack notifications to. Leave blank to disable.',
                'value' => null,
                'cast' => 'string',
                'category' => 'notifications',
            ],
            [
                'name' => 'Discord webhook',
                'info' => 'A webhook to send slack notifications to. Leave blank to disable.',
                'value' => null,
                'cast' => 'string',
                'category' => 'notifications',
            ],
        ];

        foreach ($defaults as $setting) {
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
        Schema::dropIfExists('settings');
    }
}
