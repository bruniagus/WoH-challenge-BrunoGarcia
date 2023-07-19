<?php

namespace App\Http\Controllers;

use App\Models\{Player,Item,InventoryItem};
use App\Http\Requests\{EquipItemPlayerControllerRequest,InventoryItemPlayerControllerRequest,UnequipItemPlayerControllerRequest};


class InventoryItemController extends Controller
{
    public function equipItem(EquipItemPlayerControllerRequest $request)
    {
        $player = Player::findOrFail($request->player_id);
        $item = Item::findOrFail($request->item_id);

        // Verificar si el ítem existe en el inventario del jugador
        $inventoryItem = $this->getInventoryitemById($player->id,$item->id);

        if (!$inventoryItem) return response()->json(['message' => 'The item does not exist in the player\'s inventory.'], 400);

        // Verificar si el ítem ya está equipado
        if ($inventoryItem->equipped) return response()->json(['message' => 'The item is already equipped.'], 400);
        
        // Verificar si ya se tiene equipado un ítem del mismo tipo
        $existingItem = InventoryItem::where('player_id', $player->id)
            ->where('equipped', true)
            ->whereHas('item', function ($query) use ($item) {
                $query->where('type', $item->type);
            })
            ->first();
      
        if ($existingItem) return response()->json(['message' => 'Player already has an item of the same type equipped.'], 400);

        // Marcar el ítem como equipado
        $inventoryItem->update(['equipped' => true]);

        // Respuesta con el ítem del inventario actualizado
        return response()->json($inventoryItem, 200);
    }

    public function inventoryItem(InventoryItemPlayerControllerRequest $request)
    {
        $player = Player::findOrFail($request->player_id);
        $item = Item::findOrFail($request->item_id);

        // Verificar si el ítem existe en el inventario del jugador
        $inventoryItem = $this->getInventoryitemById($player->id,$item->id);

        if ($inventoryItem)  return response()->json(['message' => 'You already have the item'], 400);

        $inventoryItem = InventoryItem::create([
            'player_id' => $player->id,
            'item_id' => $item->id
        ]);

        return response()->json($inventoryItem, 200);
    }

    public function unequipItem(UnequipItemPlayerControllerRequest $request)
    {
        $player = Player::findOrFail($request->player_id);
        $item = Item::findOrFail($request->item_id);

        $inventoryItem = $this->getInventoryitemById($player->id,$item->id);
        
        if (!$inventoryItem)  return response()->json(['message' => 'The item does not exist in the player\'s inventory.'], 400);
        if (!$inventoryItem->equipped) return response()->json(['message' => 'The item is not equipped.'], 400);
        $inventoryItem->update(['equipped' => false]);
        
        return response()->json($inventoryItem, 200);
    }

    private function getInventoryitemById($player_id,$item_id)
    {
        return InventoryItem::where('player_id', $player_id)
            ->where('item_id', $item_id)
            ->first();
    }
}
