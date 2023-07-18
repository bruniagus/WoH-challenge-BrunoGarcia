<?php

namespace App\Listeners;

use App\Events\PlayerDefeated;

class PlayerDefeatedStatus
{
    public function handle(PlayerDefeated $event)
    {
        $player = $event->player;
        $player->is_dead = true;
        $player->save();
    }
}