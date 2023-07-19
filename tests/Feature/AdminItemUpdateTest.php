<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminItemUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminUpdateItem()
    {

        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);
    }

    public function testAdminUpdateItemButNoSendName()
    {
        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendType()
    {
        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => $this->faker->name,
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendDefensePoints()
    {
        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendAttackPoints()
    {
        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButSendInvalidType()
    {
        $item = $this->createItemFaker();

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => $this->faker->name,
            'type' => 'weapon_2',
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

 
}
