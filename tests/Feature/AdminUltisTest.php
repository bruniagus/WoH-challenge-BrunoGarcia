<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Player;
use App\Models\LogAttack;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUltisTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminUltis()
    {
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100
        ]);
        
        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe2@example.com',
            'type' => 'human',
            'health' => 100
        ]);

        $player_3 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe3@example.com',
            'type' => 'human',
            'health' => 100
        ]);
        
        LogAttack::create([
            'attacker_id' => $player_1->id,
            'defender_id' => $player_2->id,
            'attack_type' => 'melee',
            'damage' => 10
        ]);

        LogAttack::create([
            'attacker_id' => $player_2->id,
            'defender_id' => $player_3->id,
            'attack_type' => 'melee',
            'damage' => 10
        ]);


        
        $response = $this->get('/api/v1/admin/ultis/');
        // Verifica el estado de la respuesta
        $response->assertStatus(200);

        $this->assertEquals(count($response->json()), 2);
    }

}
