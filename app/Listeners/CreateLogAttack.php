<?php

namespace App\Listeners;

use App\Events\PlayerAttack;
use App\Models\{LogAttack};

class CreateLogAttack
{
    public function handle(PlayerAttack $event)
    {
        LogAttack::create([
            'attacker_id' => $event->attacker->id,
            'defender_id' => $event->defender->id,
            'attack_type' => $event->attack_type,
            'damage' => $event->damage,
        ]);
    }
}