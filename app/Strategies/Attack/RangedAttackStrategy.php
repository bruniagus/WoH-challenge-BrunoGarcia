<?php

namespace App\Strategies\Attack;

class RangedAttackStrategy implements AttackStrategy
{
    public function calculateDamage($baseAttackPoints, $itemAttackPoints, &$attacker)
    {
        $rangedAttackMultiplier = 0.8;
        return round(($baseAttackPoints + $itemAttackPoints) * $rangedAttackMultiplier);
    }
}