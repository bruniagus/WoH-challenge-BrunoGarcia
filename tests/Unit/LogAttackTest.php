<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Player,LogAttack};

class LogAttackTest extends TestCase
{
    use RefreshDatabase;
    public function testLogAttackCreation()
    {
        // Crea un jugador utilizando el modelo Player
        $player_1 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
        ]);

        $player_2 = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
        ]);

        // Crea un LogAttack asociado al jugador
        $logAttack = LogAttack::create([
            'attacker_id' => $player_1->id,
            'defender_id' => $player_2->id,
            'attack_type' => 'melee',
            'damage' => 10
        ]);

        // Verifica que el LogAttack se haya creado correctamente
        $this->assertInstanceOf(LogAttack::class, $logAttack);
        $this->assertEquals($player_1->id, $logAttack->attacker_id);
        $this->assertEquals($player_2->id, $logAttack->defender_id);
        $this->assertEquals('melee', $logAttack->attack_type);
        $this->assertEquals(10, $logAttack->damage);
        
    }
}