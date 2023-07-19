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
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();

        // Inicializa el job de ataque
        

        $job = new AttackJob($attacker->id, $defender->id,$this->getAttackTypeRandom() );

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
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();
        $defender->is_dead = true;
        $defender->health = 0;
        $defender->save();

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,$this->getAttackTypeRandom());

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testAttackerDeadInAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = $this->createUserFaker();
        $attacker->is_dead = true;
        $attacker->health = 0;
        $attacker->save();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,$this->getAttackTypeRandom());

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testInvalidTypeAttackAttackJob()
    {

        // Crea un jugador atacante utilizando el modelo Player
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee_2');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testUltiNoBeforeThrowMeleeAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();
        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'ulti');

        // Ejecuta el Job
        $this->expectException(\Exception::class);
        $job->handle();
    }

    public function testUltiBeforeThrowMeleeAttackJob()
    {
        // Crea un jugador atacante utilizando el modelo Player
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();

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
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();

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
        $attacker = $this->createUserFaker();

        // Crea un jugador defensor utilizando el modelo Player
        $defender = $this->createUserFaker();
        $defender->health = 1;
        $defender->save();

        // Crea una instancia del Job AttackJob con los jugadores correspondientes
        $job = new AttackJob($attacker->id, $defender->id,'melee');
        $job->handle();

        // Verifica que los jugadores hayan sido actualizados correctamente después del ataque
        $defender_update = Player::findOrFail($defender->id);
        $this->assertEquals($defender_update->is_dead, 1);
    }
}