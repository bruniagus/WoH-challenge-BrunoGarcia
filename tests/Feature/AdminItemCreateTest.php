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

        
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(201);

        $item = Item::where("name" ,'John')->first();
        $this->assertEquals(isset($item), true);
    }

    public function testAdminCreateItemButNoSendName()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'type' => 'boot',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendType()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendDefensePoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot',
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButNoSendAttackPoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidType()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot2',
            'defense_points' => 0,
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidDefensePoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 'Abc',
            'attack_points' => 0
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreateItemButSendInvalidAttackPoints()
    {
        
        $response = $this->post('/api/v1/admin/items/', [
            'name' => 'John',
            'type' => 'boot',
            'defense_points' => 0,
            'attack_points' => 'Abc'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }
}
