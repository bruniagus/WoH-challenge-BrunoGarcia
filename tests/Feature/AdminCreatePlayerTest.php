<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCreatePlayerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminCreatePlayer()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => 'John',
            'email' => 'john@example.com',
            'type' => 'human'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(201);

        $inventoryItem = Player::where("email" ,'john@example.com')->first();
        
        $this->assertEquals(isset($inventoryItem), true);
    }

    public function testAdminCreatePlayerButNotSendMail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => 'John',
            'type' => 'human'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButSendMailFail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => 'John',
            'email' => 'john',
            'type' => 'human'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButNotSendName()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'email' => 'john@example.com',
            'type' => 'human'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButNotSendType()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => 'John',
            'email' => 'john@example.com'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButSendTypeFail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => 'John',
            'email' => 'john@example.com',
            'type' => 'human2'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }
}
