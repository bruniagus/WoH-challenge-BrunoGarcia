<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'defense_points', 'attack_points'];

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
