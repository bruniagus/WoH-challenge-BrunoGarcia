<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipItemPlayerControllerRequest extends FormRequest
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
            'playerId' => 'required|exists:players,id',
            'itemId' => 'required|exists:items,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'playerId' => (int) $this->playerId
        ]);
    }
}
