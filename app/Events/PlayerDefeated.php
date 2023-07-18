<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerDefeated
{
    use Dispatchable, SerializesModels;

    public $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
}
