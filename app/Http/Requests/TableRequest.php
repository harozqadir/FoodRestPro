<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
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
            'table_number' => 'required|string|unique:tables,table_number,'
        ];
    }

    public function messages()
{
    return [
        'table_number.required' => 'تکایە ژمارەی میزی هەلبژێرە.',
        'table_number.string'   => 'تکایە ژمارەی میزی هەلبژێرە.',
        'table_number.unique'   => 'ژمارەی میزی هەلبژێردراو پێشتر هەبوو.',
    ];
}
}
