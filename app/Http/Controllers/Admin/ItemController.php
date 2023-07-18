<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Item};
use App\Http\Requests\{CreateItemAdminControllerRequest,UpdateItemAdminControllerRequest};
use App\Http\Controllers\Controller;

class ItemController extends Controller
{

    public function createItem(CreateItemAdminControllerRequest $request)
    {
        $item = Item::create([
            'name' => $request->name,
            'type' => $request->type,
            'defense_points' => $request->defense_points,
            'attack_points' => $request->attack_points
        ]);

        // Respuesta con el ítem creado
        return response()->json($item, 201);
    }

    public function updateItem(UpdateItemAdminControllerRequest $request)
    {
        $item = Item::findOrFail($request->item_id);
        $item->update($request->all());

        // Respuesta con el ítem actualizado
        return response()->json($item, 200);
    }
}
