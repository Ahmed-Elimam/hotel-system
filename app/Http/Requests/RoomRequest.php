<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
            'room_number' => ['required', 'integer', 'min:1000', 'max:9999', Rule::unique('rooms')->ignore($this->id)],
            'capacity' => 'required|integer|min:1|max:6',
            'price' => 'required|integer|min:1',
            'floor_id' => 'required|exists:floors,id',
           
        ];
    }
    public function messages()
{
    return [
        'price.required' => 'The price is required.',
        'price.integer' => 'The price must be an integer.',
        'price.min' => 'The price must be at least 100 dollar.',
        'floor_id.required' => 'The floor must be chosen.',
        
    ];
}

}
