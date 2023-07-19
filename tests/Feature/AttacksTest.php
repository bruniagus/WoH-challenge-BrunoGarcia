<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Player;
use App\Models\Item;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttacksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAttackMelee()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = $this->createUserFaker();

        $player_2 = $this->createUserFaker();

        $response = $this->post('/api/v1/attacks/',[
            "attacker_id" => $player_1->id,
            "defender_id" => $player_2->id,
            "attack_type" => "melee"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);

    }

    public function testAttackRanged()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = $this->createUserFaker();

        $player_2 = $this->createUserFaker();

        $response = $this->post('/api/v1/attacks/',[
            "attacker_id" => $player_1->id,
            "defender_id" => $player_2->id,
            "attack_type" => "ranged"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);

    }

    public function testAttackUltiWithoutFirstAttackMelee()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = $this->createUserFaker();

        $player_2 = $this->createUserFaker();

        $response = $this->post('/api/v1/attacks/',[
            "attacker_id" => $player_1->id,
            "defender_id" => $player_2->id,
            "attack_type" => "ulti"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(400);
    }
    
    public function testAttackUltiFirstAttackMelee()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = $this->createUserFaker();

        $player_2 = $this->createUserFaker();

        $response = $this->post('/api/v1/attacks/',[
            "attacker_id" => $player_1->id,
            "defender_id" => $player_2->id,
            "attack_type" => "melee"
        ]);

        $response = $this->post('/api/v1/attacks/',[
            "attacker_id" => $player_1->id,
            "defender_id" => $player_2->id,
            "attack_type" => "ulti"
        ]);


        // Verifica el estado de la respuesta
        $response->assertStatus(200);
    }
}
