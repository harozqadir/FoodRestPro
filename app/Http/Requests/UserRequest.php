<?php

namespace App\Http\Requests;

use Illuminate\Http\Request; // use Laravel's Request instead of Guzzle's
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(Request $request): array
{
    if (in_array($this->method(), ['PUT', 'PATCH'])) {
        return [
            'username' => 'required| string|max:255|unique:users',
            'password' => 'nullable|string|min:6|max:256|confirmed',
            'role'     => 'required|in:1,2,3,4',
            'created_by' => auth()->id(), // Set the creator's user ID

        ];
    }

    // Default rules for other methods (e.g., POST)
    return [
        'username' => 'required| string|max:255|unique:users',
        'password' => 'required|string|min:6|max:256|confirmed',
        'role'     => 'required|in:1,2,3,4',
    ];
}
}