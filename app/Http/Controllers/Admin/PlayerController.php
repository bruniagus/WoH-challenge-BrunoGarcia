<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Player};
use App\Http\Requests\{CreatePlayerAdminControllerRequest};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function createPlayer(CreatePlayerAdminControllerRequest $request)
    {
        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type
        ]);
       
        // Respuesta con el jugador creado
        return response()->json($player, 201);
    }

    public function getPlayersWithUlti(Request $request)
    {
        $players = Player::get();
        $playersWithUlti = [];

        foreach ($players as $player)
            if($player->lastAttackWasMelee()) $playersWithUlti[] = $player;

        return response()->json($playersWithUlti);
    }
}
