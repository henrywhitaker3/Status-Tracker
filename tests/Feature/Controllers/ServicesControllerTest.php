<?php

namespace Tests\Feature\Controllers;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServicesControllerTest extends TestCase
{
    use WithFaker;

    /**
     * Test storing a service
     *
     * @return void
     */
    public function test_it_stores_a_service()
    {
        $response = $this->put(route('services.store'), [
            'type' => 'http',
            'name' => $name = $this->faker->name,
            'access_url' => $access = $this->faker->url,
            'check_url' => $check = $this->faker->url,
            'enabled' => true,
        ]);

        $service = Service::first();

        $response->assertStatus(302);
        $response->assertRedirect(route('services.show', ['service' => $service->id]));

        $this->assertEquals($name, $service->name);
        $this->assertEquals('http', $service->type);
        $this->assertEquals($access, $service->access_url);
        $this->assertEquals($check, $service->check_url);
    }

    /**
     * Test storing a service
     *
     * @return void
     */
    public function test_it_doesnt_store_a_service_when_input_invalid()
    {
        $response = $this->put(route('services.store'), [
            'type' => 'test',
            'name' => $name = $this->faker->name,
            'access_url' => $access = $this->faker->url,
            'check_url' => $check = $this->faker->url,
            'enabled' => true,
        ]);

        $response->assertStatus(302);

        $this->assertEquals(0, Service::count());
    }

    public function test_it_deletes_a_service()
    {
        $service = Service::factory()->create();

        $this->assertNotNull(Service::find($service->id));

        $this->delete(route('services.destroy', ['service' => $service->id]));

        $this->assertNull(Service::find($service->id));
    }
}
