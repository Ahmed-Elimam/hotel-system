<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',
                        Rule::unique('users')->ignore($this->user_id)],
            'password' => ['required', 'string', 'min:6'],
            'password_confirmation' => ['required', 'string', 'min:6', 'same:password'],
            'national_id' => ['required','string', 'size:14', 'unique:users', 
                        Rule::unique('users')->ignore($this->client)],
            'avatar_image' => ['nullable','mimes:jpg,jpeg', 'max:2048'],
            'phone' => ['required', 'string', 'max:255'],
            'gender' => ['required' ,'in:male,female'],
            'country' => ['required', 'exists:countries,id'],
        ];
    }
}
