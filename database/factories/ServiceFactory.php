<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class ServiceFactory extends Factory
{
    use WithFaker;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker()->name(),
            'check_url' => $this->faker()->url,
            'access_url' => $this->faker()->url,
            'status' => (bool) rand(0, 1),
            'enabled' => (bool) rand(0, 1),
            'type' => array_rand(Service::types()),
        ];
    }
}
