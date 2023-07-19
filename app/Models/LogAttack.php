<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogAttack extends Model
{
    use HasFactory;
    
    protected $fillable = ['attacker_id', 'defender_id', 'attack_type', 'damage'];

    public function attacker()
    {
        return $this->belongsTo(Player::class, 'attacker_id');
    }

    public function defender()
    {
        return $this->belongsTo(Player::class, 'defender_id');
    }
}
