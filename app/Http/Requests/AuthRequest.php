<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'username' => 'required|min:3|max:50',
            'email'    => 'required|min:10',
            'password' => 'required|min:8|max:18'
        ];

        if ($this->route()->uri() === 'authentication/signin') {
            unset($rules['username']);
        }

        return $rules;
    }
}
