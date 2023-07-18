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
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);

        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $response = $this->post('/api/v1/attacks/',[
            "attackerId" => $player_1->id,
            "defenderId" => $player_2->id,
            "attackType" => "melee"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);

    }

    public function testAttackRanged()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);

        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $response = $this->post('/api/v1/attacks/',[
            "attackerId" => $player_1->id,
            "defenderId" => $player_2->id,
            "attackType" => "ranged"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);

    }

    public function testAttackUltiWithoutFirstAttackMelee()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);

        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $response = $this->post('/api/v1/attacks/',[
            "attackerId" => $player_1->id,
            "defenderId" => $player_2->id,
            "attackType" => "ulti"
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(400);
    }
    
    public function testAttackUltiFirstAttackMelee()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);

        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);

        $response = $this->post('/api/v1/attacks/',[
            "attackerId" => $player_1->id,
            "defenderId" => $player_2->id,
            "attackType" => "melee"
        ]);

        $response = $this->post('/api/v1/attacks/',[
            "attackerId" => $player_1->id,
            "defenderId" => $player_2->id,
            "attackType" => "ulti"
        ]);


        // Verifica el estado de la respuesta
        $response->assertStatus(200);
    }
}
