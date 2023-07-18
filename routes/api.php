<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{ItemController,PlayerController};
use App\Http\Controllers\{AttackController,InventoryItemController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
    // Rutas para los contraoladores de administracion
    Route::post('admin/players', [PlayerController::class, 'createPlayer']);
    Route::get('admin/ultis', [PlayerController::class, 'getPlayersWithUlti']);
    Route::post('admin/items', [ItemController::class, 'createItem']);
    Route::put('admin/items/{item_id}', [ItemController::class, 'updateItem']);
    // Rutas para el controlador de ataque
    Route::post('attacks', [AttackController::class, 'attack']);
    // Rutas para el controlador del inventario del player
    Route::post('items/equip/{player_id}', [InventoryItemController::class, 'equipItem']);
    Route::post('items/unequip/{player_id}', [InventoryItemController::class, 'unequipItem']);
    Route::post('items/inventory/{player_id}', [InventoryItemController::class, 'inventoryItem']);
});