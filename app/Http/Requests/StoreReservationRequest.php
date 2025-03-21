<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'accompany_number' => 'required|integer|min:4',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'paid_price' => 'required|integer|min:1',
            'room_id' => 'required|exists:rooms,id',
            'client_id' => 'required|exists:users,id',
        ];
    }
}
