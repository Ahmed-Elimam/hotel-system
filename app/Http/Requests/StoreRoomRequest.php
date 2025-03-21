<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'capacity' => 'required|integer|min:1|max:4',
            'price' => 'required|integer|min:1',
            'is_reserved' => 'required|boolean' ,
            'floor_id' => 'required|exists:floors,id',
        ];
    }
}
