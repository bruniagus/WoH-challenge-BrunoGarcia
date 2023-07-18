<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{Player};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\AttackJob;
use App\Strategies\Attack\{MeleeAttackStrategy,RangedAttackStrategy,UltiAttackStrategy};

class AttackJobTest extends TestCase
{
    use RefreshDatabase;
    
    public function testAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie',
            'health' => 100
        ]);

        // Inicializa el job de ataque
        

        $job = new AttackJob($attacker->id, $defender->id,'melee');
        dispatch_sync($job);

        $defender_update = Player::findOrFail($defender->id);

        $attacker->setAttackStrategy(new MeleeAttackStrategy());

        $damage = $attacker->getAttackDamage();
        $damage -= $defender->calculateDefensePoints();
        $damage = max(1, $damage);

        // Verifica que los jugadores hayan sido actualizados correctamente después del ataque
        $this->assertEquals($defender_update->health, $defender->health - $damage);
    }

    public function testDefenderDeadInAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie',
            'is_dead' => true,
            'health' => 0
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testAttackDeadInAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 0,
            'is_dead' => true,
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie'
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testInvalidTypeAttackAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human'
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie'
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee_2');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testUltiNoBeforeThrowMeleeAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human'
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie'
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'ulti');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testUltiBeforeThrowMeleeAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human'
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie',
            'health' => 100
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee');
        $job->handle();

        $job = new AttackJob($attacker->id, $defender->id,'ulti');
        $job->handle();

        
        // Verifica que los jugadores hayan sido actualizados correctamente después del ataque
        $attacker->setAttackStrategy(new MeleeAttackStrategy());

        $damage = $attacker->getAttackDamage();
        $damage -= $defender->calculateDefensePoints();
        $damage = max(1, $damage);

        $attacker->setAttackStrategy(new UltiAttackStrategy());

        $damage += $attacker->getAttackDamage();
        $damage -= $defender->calculateDefensePoints();
        $damage = max(1, $damage);
        
        $defender_update = Player::findOrFail($defender->id);

        $this->assertEquals($defender_update->health, $defender->health - $damage);
    }

    public function testRangedAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human'
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie',
            'health' => 100
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'ranged');
        $job->handle();


        // Verifica que los jugadores hayan sido actualizados correctamente después del ataque
        $attacker->setAttackStrategy(new RangedAttackStrategy());

        $damage = $attacker->getAttackDamage();
        $damage -= $defender->calculateDefensePoints();
        $damage = max(1, $damage);
        
        $defender_update = Player::findOrFail($defender->id);

        $this->assertEquals($defender_update->health, $defender->health - $damage);
    }

    public function testKillAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human'
        ]);

        // Crea un jugador defensor utilizando el modelo Player
        $defender = Player::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'type' => 'zombie',
            'health' => 1
        ]);

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee');
        $job->handle();

        // Verifica que los jugadores hayan sido actualizados correctamente después del ataque
        $defender_update = Player::findOrFail($defender->id);
        $this->assertEquals($defender_update->is_dead, 1);
    }
}