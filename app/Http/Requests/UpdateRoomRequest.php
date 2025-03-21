<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'capacity' => 'required|integer|min:1|max:4',
            'price' => 'required|integer|min:1',
            'is_reserved' => 'required|boolean' ,
            'floor_id' => 'required|exists:floors,id',
        ];
    }
}
