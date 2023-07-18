<?php

namespace App\Strategies\Attack;

interface AttackStrategy
{
    public function calculateDamage($baseAttackPoints, $itemAttackPoints, &$attacker);
}