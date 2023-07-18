<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryItemPlayerControllerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'player_id' => 'required|exists:players,id',
            'item_id' => 'required|exists:items,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'player_id' => $this->player_id
        ]);
    }
}
