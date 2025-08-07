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
            'username' => 'required|string|unique:users,username,' . $this->route('id') . '|max:255',
            'password' => 'nullable|string|min:6|max:255|confirmed',
            'role'     => 'required|in:1,2,3,4',
        ];
    } else {
        return [
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'role'     => 'required|in:1,2,3,4',
        ];
    }
}
public function messages()
{
    return [
        'username.required' => 'ناوی بەکارهێنەر پێویستە.',
        'password.required' => 'وشەی نهێنی پێویستە.',
        'password.confirmed' => 'دڵنیاکردنەوەی وشەی نهێنی هەمان وشە دەبێت.',
        'role.required'     => 'تکایە ڕۆڵ هەلبژێرە.',
        'password_confirmation.required' => 'تکایە وشەی نهێنی دووبارە بنووسە.',        // Add more as needed
    ];
}
}