<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'room_number' => 'required|integer|unique:rooms|min:1000|max:9999',
            'capacity' => 'required|integer|min:1|max:6',
            'price' => 'required|integer|min:100',
            'floor_id' => 'required|exists:floors,id',
        ];
    }
    public function messages()
{
    return [
        'price.required' => 'The price is required. Please enter it in cents (e.g., 1050 for $10.50).',
        'price.integer' => 'The price must be an integer (e.g., 1050 for $10.50, not 10.50).',
        'price.min' => 'The price must be at least 100 cent.',
    ];
}

}
