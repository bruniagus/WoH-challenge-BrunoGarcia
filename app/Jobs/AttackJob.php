<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Player,LogAttack};
use App\Strategies\Attack\{MeleeAttackStrategy,RangedAttackStrategy,UltiAttackStrategy};
use App\Events\PlayerDefeated;

class AttackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attackerId;
    protected $defenderId;
    protected $attackType;

    public function __construct($attackerId, $defenderId, $attackType)
    {
        $this->attackerId = $attackerId;
        $this->defenderId = $defenderId;
        $this->attackType = $attackType;
    }

    public function handle()
    {
        
        $attacker = Player::findOrFail($this->attackerId);
        $defender = Player::findOrFail($this->defenderId);
        

        // Verificar si el atacante está muerto
        if ($attacker->health <= 0 || $attacker->is_dead == true)  throw new \Exception('The attacker is already dead.');

        // Verificar si el defensor está muerto
        if ($defender->health <= 0 || $defender->is_dead == true)  throw new \Exception('The defender is already dead.');
    
        // Establecer la estrategia de ataque según el tipo de ataque
        switch ($this->attackType) {
            case 'melee':
                $attacker->setAttackStrategy(new MeleeAttackStrategy());
                break;
            case 'ranged':
                $attacker->setAttackStrategy(new RangedAttackStrategy());
                break;
            case 'ulti':
                $attacker->setAttackStrategy(new UltiAttackStrategy());
                break;
            default:
                return throw new \Exception('Invalid attack type.');
        }
        
        // Calcular el daño del ataque
        $damage = $attacker->getAttackDamage();
    
        // Aplicar la defensa del defensor
        $damage -= $defender->calculateDefensePoints();
    
        // Verificar que el daño mínimo sea 1
        $damage = max(1, $damage);
        
        // Restar el daño a la salud del defensor
        $defender->health -= $damage;
        $defender->save();
        // Guardar el ataque en el registro de log
        LogAttack::create([
            'attacker_id' => $attacker->id,
            'defender_id' => $defender->id,
            'attack_type' => $this->attackType,
            'damage' => $damage,
        ]);
    
        // Eventos por la muerte del defensor 
        if ($defender->health <= 0) event(new PlayerDefeated($defender));
    }
}