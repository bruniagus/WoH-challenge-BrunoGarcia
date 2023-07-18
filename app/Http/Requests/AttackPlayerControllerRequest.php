<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttackPlayerControllerRequest extends FormRequest
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
            'attackerId' => 'required|exists:players,id',
            'defenderId' => ['required','exists:players,id',$this->differentAttack()],
            'attackType' => 'required|in:melee,ranged,ulti',
        ];
    }

    public function differentAttack()
    {
        return function ($attribute, $value, $fail) {
            if ($value == $this->attackerId) {
                $fail("The attacker and defender cannot be the same");
            }
        };
    }
}
