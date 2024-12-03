<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string|min:3|max:50|alpha_dash:ascii',
            'phone' => 'required|string|regex:/^\+?[0-9]{7,15}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Username is required.',
            'login.min' => 'Username must be at least 3 characters.',
            'login.max' => 'Username may not be greater than 50 characters.',
            'login.alpha_dash:ascii' => 'Username must contain only letters, numbers, dashes, or underscores.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number format is invalid.',
        ];
    }
}
