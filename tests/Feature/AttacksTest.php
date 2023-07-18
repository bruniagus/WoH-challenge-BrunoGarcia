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


        $response = $this->post('/api/v1/attacks/' . $player_1->id .'/'. $player_2->id .'/melee');

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


        $response = $this->post('/api/v1/attacks/' . $player_1->id .'/'. $player_2->id .'/ranged');

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


        $response = $this->post('/api/v1/attacks/' . $player_1->id .'/'. $player_2->id .'/ulti');

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

        $this->post('/api/v1/attacks/' . $player_1->id .'/'. $player_2->id .'/melee');
        $response = $this->post('/api/v1/attacks/' . $player_1->id .'/'. $player_2->id .'/ulti');

        // Verifica el estado de la respuesta
        $response->assertStatus(200);
    }
}
