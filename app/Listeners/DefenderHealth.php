<?php

namespace App\Listeners;

use App\Events\PlayerAttack;

class DefenderHealth
{
    public function handle(PlayerAttack $event)
    {
        $defender = $event->defender;
        $defender->health -= $event->damage;
        $defender->save();
    }
}