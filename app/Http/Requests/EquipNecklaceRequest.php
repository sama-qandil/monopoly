<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipNecklaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'slot_id'     => 'required|exists:necklace_slots,id',
        'necklace_id' => 'required|exists:necklaces,id',
        ];
    }
}
