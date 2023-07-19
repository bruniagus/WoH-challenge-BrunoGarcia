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
        $email = $this->faker->email;
        $response = $this->post('/api/v1/admin/players/', [
            'name' => $this->faker->name,
            'email' => $email,
            'type' => $this->faker->randomElement(['human', 'zombie'])
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(201);

        $inventoryItem = Player::where("email" ,$email)->first();
        
        $this->assertEquals(isset($inventoryItem), true);
    }

    public function testAdminCreatePlayerButNotSendMail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['human', 'zombie'])
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButSendMailFail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => $this->faker->name,
            'email' => 'john',
            'type' => $this->faker->randomElement(['human', 'zombie'])
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButNotSendName()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'email' => $this->faker->email,
            'type' => $this->faker->randomElement(['human', 'zombie'])
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButNotSendType()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }

    public function testAdminCreatePlayerButSendTypeFail()
    {
        
        $response = $this->post('/api/v1/admin/players/', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'type' => 'human2'
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(302);
    }
}
