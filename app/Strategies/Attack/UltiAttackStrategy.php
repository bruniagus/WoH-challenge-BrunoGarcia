<?php

namespace App\Strategies\Attack;

class UltiAttackStrategy implements AttackStrategy
{
    public function calculateDamage($baseAttackPoints, $itemAttackPoints, &$attacker)
    {

        if (!$attacker->lastAttackWasMelee()) {
            throw new \Exception('Cannot use Ulti attack. Last attack was not a melee attack.');
        }
        
        $ultiAttackMultiplier = 2;
        return ($baseAttackPoints + $itemAttackPoints) * $ultiAttackMultiplier;
    }
}