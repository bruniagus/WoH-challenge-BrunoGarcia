<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemAdminControllerRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'type' => [
                'required',
                Rule::in(['boot', 'armor' , 'weapon']),
            ],
            'defense_points' => 'required|integer|min:0',
            'attack_points' => 'required|integer|min:0'
        ];
    }
}
