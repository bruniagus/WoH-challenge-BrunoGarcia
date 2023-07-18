<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    public function testItemCreation()
    {
        // Crea un item utilizando el modelo Item
        $item = Item::create([
            'name' => 'Sword',
            'type' => 'weapon',
            'defense_points' => 5,
            'attack_points' => 10,
        ]);

        // Verifica que el item se haya creado correctamente
        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('Sword', $item->name);
        $this->assertEquals('weapon', $item->type);
        $this->assertEquals(5, $item->defense_points);
        $this->assertEquals(10, $item->attack_points);
    }
}