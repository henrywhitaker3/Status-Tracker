<?php

namespace Tests\Feature\Models;

use App\Models\Setting;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /**
     * Test retrieving a setting casts to a bool.
     *
     * @return void
     */
    public function test_it_casts_to_bool()
    {
        Setting::create([
            'name' => 'test_setting',
            'value' => 'true',
            'cast' => 'bool',
        ]);

        $this->assertEquals(
            true,
            Setting::retrieve('test_setting', true)
        );
    }

    /**
     * Test retrieving a setting casts to a string.
     *
     * @return void
     */
    public function test_it_casts_to_string()
    {
        Setting::create([
            'name' => 'test_setting',
            'value' => true,
            'cast' => 'string',
        ]);

        $this->assertEquals(
            '1',
            Setting::retrieve('test_setting', true)
        );
    }

    /**
     * Test that the retrieve method stores and retrieves
     * from the static array without repeating queries.
     *
     * @return void
     */
    public function test_it_doesnt_repeat_queries()
    {
        Setting::$settings = [];

        DB::enableQueryLog();

        Setting::retrieve('Slack webhook');
        Setting::retrieve('Slack webhook');

        $this->assertCount(1, DB::getQueryLog());
    }

    /**
     * Test that the retrieve method stores and retrieves
     * from the static array without repeating queries.
     *
     * @return void
     */
    public function test_it_doesnt_repeat_queries_after_get_all()
    {
        DB::enableQueryLog();

        Setting::getAll();

        Setting::retrieve('Slack webhook');
        Setting::retrieve('Slack webhook');

        $this->assertCount(1, DB::getQueryLog());
    }
}
