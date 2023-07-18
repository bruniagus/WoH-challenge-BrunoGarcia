<?php

namespace App\Http\Controllers;

use App\Jobs\AttackJob;
use App\Http\Requests\{AttackPlayerControllerRequest};


class AttackController extends Controller
{
    public function attack(AttackPlayerControllerRequest $request)
    {
        try {
            // Crear y despachar el trabajo de ataque en la cola
            AttackJob::dispatch($request->attacker_id, $request->defender_id, $request->attack_type)
                ->onQueue('attacks');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],400);
        }
        // Respuesta con el resultado del ataque
        return response()->json(['message' => $request->attack_type.' attack successful.'], 200);
    }
}
