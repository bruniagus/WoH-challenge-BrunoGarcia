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

        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);
    }

    public function testAdminUpdateItemButNoSendName()
    {
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'type' => 'boot',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendType()
    {
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => 'John',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendDefensePoints()
    {
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => 'John',
            'type' => 'boot',
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButNoSendAttackPoints()
    {
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminUpdateItemButSendInvalidType()
    {
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        // Envía una solicitud put a la ruta con el jugador y el item
        $response = $this->put('/api/v1/admin/items/' . $item->id, [
            'name' => 'John',
            'type' => 'boot2',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

 
}
