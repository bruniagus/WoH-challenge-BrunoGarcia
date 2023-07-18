<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Player;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Strategies\Attack\{MeleeAttackStrategy,RangedAttackStrategy,UltiAttackStrategy};

class PlayerTest extends TestCase
{
    use RefreshDatabase;
    public function testPlayerCreation()
    {
        // Crea un jugador utilizando el modelo Player
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100
        ]);

        // Verifica que el jugador se haya creado correctamente
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('John Doe', $player->name);
        $this->assertEquals('johndoe@example.com', $player->email);
        $this->assertEquals('human', $player->type);
        $this->assertEquals(100, $player->health);
    }

    public function testPlayerAttackPoints()
    {
        // Crea un jugador con un item de ataque que suma 10 puntos de ataque
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
        ]);

        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true
        ]);

        // Verifica que los puntos de ataque se calculen correctamente
        $player->setAttackStrategy(new MeleeAttackStrategy());
        $this->assertEquals(15, $player->getAttackDamage());

        $player->setAttackStrategy(new RangedAttackStrategy());
        $this->assertEquals(12, $player->getAttackDamage());

        $player_2 = Player::create([
            'name' => 'John Doe 2',
            'email' => 'johndoe2@example.com',
            'type' => 'zombie',
        ]);

        $player->logAttacks()->create([
            'attacker_id' => $player->id,
            'defender_id' => $player_2->id,
            'attack_type' => 'melee',
            'damage' => 1
        ]);

        $player->setAttackStrategy(new UltiAttackStrategy());
        $this->assertEquals(30, $player->getAttackDamage());
    }

    public function testPlayerDefensePoints()
    {
        // Crea un jugador con un item de defensa que suma 5 puntos de defensa
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
        ]);

        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 0,
            'defense_points' => 5,
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true
        ]);

        // Verifica que los puntos de defensa se calculen correctamente
        $this->assertEquals(10, $player->calculateDefensePoints());
    }
}