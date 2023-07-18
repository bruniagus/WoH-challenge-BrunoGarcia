<?php

namespace App\Strategies\Attack;

class MeleeAttackStrategy implements AttackStrategy
{
    public function calculateDamage($baseAttackPoints, $itemAttackPoints, &$attacker)
    {
        return $baseAttackPoints + $itemAttackPoints;
    }
}