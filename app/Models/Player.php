<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Strategies\Attack\AttackStrategy;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use Notifiable ,HasFactory;
    private const BASE_ATTACK = 5;
    private const BASE_DEFENSE = 5;
    protected $fillable = ['name', 'email', 'type', 'health'];

    protected $attackStrategy = null;

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function logAttacks()
    {
        return $this->hasMany(LogAttack::class, 'attacker_id');
    }

    public function setAttackStrategy(AttackStrategy $attackStrategy)
    {
        $this->attackStrategy = $attackStrategy;
    }

    public function getAttackDamage()
    {
        if (!$this->attackStrategy)  throw new \Exception('Attack strategy is not set.');

        return $this->attackStrategy->calculateDamage(self::BASE_ATTACK, $this->pointItems( $this->equippedItems)->sum('attack_points') ,$this);
    }

    public function pointItems($equippedItems)
    {
        return $equippedItems->map(function ($inventoryItem) {
            return [
                'attack_points' => $inventoryItem->item->attack_points,
                'defense_points' => $inventoryItem->item->defense_points,
            ];
        });
    }

    public function equippedItems()
    {
        return $this->hasMany(InventoryItem::class)
            ->where('equipped', true)
            ->with('item');
    }

    public function calculateDefensePoints()
    {

        return $this->pointItems( $this->equippedItems)->sum('defense_points') + self::BASE_DEFENSE;
    }

    public function lastAttackWasMelee()
    {
        $lastAttack = LogAttack::where('attacker_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();
   
        return ($lastAttack && $lastAttack->attack_type === 'melee') ? true: false;
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
