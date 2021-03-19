<?php

namespace Tests\Unit\Rules;

use App\Rules\SettingsArrayRule;
use PHPUnit\Framework\TestCase;

class SettingsArrayRuleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_passes_when_id_is_present()
    {
        $array = [
            [
                'id' => 1,
                'value' => 'test'
            ]
        ];

        $rule = new SettingsArrayRule();

        $this->assertTrue(
            $rule->passes('array', $array)
        );
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_doesnt_pass_when_id_is_missing()
    {
        $array = [
            [
                'value' => 'test'
            ]
        ];

        $rule = new SettingsArrayRule();

        $this->assertFalse(
            $rule->passes('array', $array)
        );
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_doesnt_pass_when_its_not_an_array()
    {
        $array = 'test';

        $rule = new SettingsArrayRule();

        $this->assertFalse(
            $rule->passes('array', $array)
        );
    }
}
