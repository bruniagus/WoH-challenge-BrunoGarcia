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
        $player_1 = $this->createUserFaker();
        
        $player_2 = $this->createUserFaker();

        $player_3 = $this->createUserFaker();
        
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
