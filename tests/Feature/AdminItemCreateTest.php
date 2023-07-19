<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Player;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminItemCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminCreateItem()
    {
        $name = $this->faker->name;
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(201);

        $item = Item::where("name" ,$name)->first();
        $this->assertEquals(isset($item), true);
    }

    public function testAdminCreateItemButNoSendName()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendType()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendDefensePoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendAttackPoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidType()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'type' => 'boot_2',
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidDefensePoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => 'abc',
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidAttackPoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => 'abc'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }
}
