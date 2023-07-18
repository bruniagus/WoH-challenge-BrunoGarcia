<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Player;
use App\Models\Item;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEquipItem()
    {
        // Crea un jugador utilizando el modelo Player
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => false
        ]);

        
        $response = $this->post('/api/v1/items/equip/' . $player->id, [
            'item_id' => $item->id,
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(200);

        // Realiza las validaciones adicionales según tus necesidades
        // Verifica si el item se ha equipado correctamente en el jugador
        $inventoryItem = InventoryItem::where("player_id" ,$player->id)->where("item_id" , $item->id)->first();

        $this->assertEquals($inventoryItem->equipped, 1);
    }

    public function testEquipmentButAlreadyHavingEquipped()
    {
        // Crea un jugador utilizando el modelo Player
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true
        ]);

        
        $response = $this->post('/api/v1/items/equip/' . $player->id, [
            'item_id' => $item->id,
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(400);

        // Realiza las validaciones adicionales según tus necesidades
        // Verifica si el item se ha equipado correctamente en el jugador
        $inventoryItem = InventoryItem::where("player_id" ,$player->id)->where("item_id" , $item->id)->first();

        $this->assertEquals($inventoryItem->equipped, 1);
    }

    public function testEquipmentButYouHaveNoItem()
    {
        // Crea un jugador utilizando el modelo Player
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        
        $response = $this->post('/api/v1/items/equip/' . $player->id, [
            'item_id' => $item->id,
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(400);

        // Realiza las validaciones adicionales según tus necesidades
        // Verifica si el item se ha equipado correctamente en el jugador
        $inventoryItem = InventoryItem::where("player_id" ,$player->id)->where("item_id" , $item->id)->first();

        $this->assertEquals($inventoryItem, null);
    }

    public function testEquipmentButYouHaveOneofTheSameTypeEquipped()
    {
        // Crea un jugador utilizando el modelo Player
        $player = Player::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'type' => 'human',
            'health' => 100,
        ]);


        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        $item_2 = Item::create([
            'name' => 'Sword_2',
            'type' => 'weapon',
            'attack_points' => 10,
            'defense_points' => 0,
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item->id,
            'equipped' => true
        ]);

        $player->inventoryItems()->create([
            'player_id' => $player->id,
            'item_id' => $item_2->id,
            'equipped' => false
        ]);

        
        $response = $this->post('/api/v1/items/equip/' . $player->id, [
            'item_id' => $item_2->id,
        ]);

        // Verifica el estado de la respuesta
        $response->assertStatus(400);

        // Realiza las validaciones adicionales según tus necesidades
        // Verifica si el item se ha equipado correctamente en el jugador
        $inventoryItem = InventoryItem::where("player_id" ,$player->id)->where("item_id" , $item_2->id)->first();
        
        $this->assertEquals($inventoryItem->equipped, false);
    }
}
