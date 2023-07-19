<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\{Item,Player,InventoryItem};
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryItemTest extends TestCase
{
    use RefreshDatabase;
    public function testItemCreation()
    {
        // Crea un jugador utilizando el modelo Player
        $player = $this->createUserFaker();

        // Crea un item utilizando el modelo Item
        $item = $this->createItemFaker();

        // Crea un InventoryItem asociando el jugador y el item
        $inventoryItem = InventoryItem::create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true,
        ]);

        // Verifica que el InventoryItem se haya creado correctamente
        $this->assertInstanceOf(InventoryItem::class, $inventoryItem);
        $this->assertEquals($player->id, $inventoryItem->player_id);
        $this->assertEquals($item->id, $inventoryItem->item_id);
        $this->assertTrue($inventoryItem->equipped);
    }

    public function testInventoryItemRelations()
    {
        // Crea un jugador utilizando el modelo Player
        $player = $this->createUserFaker();

        // Crea un item utilizando el modelo Item
        $item = $this->createItemFaker();

        // Crea un InventoryItem asociando el jugador y el item
        $inventoryItem = InventoryItem::create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true,
        ]);

        // Verifica las relaciones entre InventoryItem, Player y Item
        $this->assertInstanceOf(Player::class, $inventoryItem->player);
        $this->assertInstanceOf(Item::class, $inventoryItem->item);
        $this->assertEquals($player->id, $inventoryItem->player->id);
        $this->assertEquals($item->id, $inventoryItem->item->id);
    }
}