<?php

namespace App\Listeners;

use App\Events\PlayerDefeated;
use App\Notifications\PlayerDefeatedNotification;

class SendPlayerDefeatedNotification
{
    public function handle(PlayerDefeated $event)
    {
        $player = $event->player;
        $player->notify(new PlayerDefeatedNotification());
    }
}