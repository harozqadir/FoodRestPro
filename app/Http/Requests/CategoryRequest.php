<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_ckb' => ['required', 'string', 'max:255'],
            'image' => ''.($this->isMethod('PUT') ? 'nullable' : 'required').'|mimes:png,jpg,jpeg|max:10240',
            
        ];
    }
    public function messages()
{
    return [
        'name_ckb.required' => 'تکایە ناوی پۆل بە کوردی بنووسە.',
        'name_ar.required'  => 'تکایە ناوی پۆل بە عەرەبی بنووسە.',
        'name_en.required'  => 'تکایە ناوی پۆل بە ئینگلیزی بنووسە.',
        'image.required'    => 'تکایە وێنەی پۆل هەڵبژێرە.',
        // Add more fields as needed
    ];
}
}
