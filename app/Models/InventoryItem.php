<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;
    
    protected $fillable = ['player_id', 'item_id', 'equipped'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
