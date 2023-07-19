<?php

namespace App\Events;

use App\Models\Player;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerAttack
{
    use Dispatchable, SerializesModels;

    public $attacker;
    public $defender;
    public $attack_type;
    public $damage;

    public function __construct(Player $attacker,Player $defender,string $attack_type, int $damage)
    {
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->attack_type = $attack_type;
        $this->damage = $damage;
    }
}
