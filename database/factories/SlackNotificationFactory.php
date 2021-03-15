<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlackNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => Service::factory()->create(),
            'webhook_url' => 'test',
        ];
    }
}
