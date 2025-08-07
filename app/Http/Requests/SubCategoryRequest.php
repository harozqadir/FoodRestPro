<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
        'name_ckb' => 'required|string|max:255',
        'name_ar' => 'required|string|max:255',
        'name_en' => 'required|string|max:255',
        'image' => ''.($this->isMethod('PUT') ? 'nullable' : 'required').'|mimes:png,jpg,jpeg|max:10240',
        'category_id' => 'required|exists:categories,id', ];
    }

    public function messages()
{
    return [
        'name_ckb.required'    => 'تکایە ناوی پۆل  بە کوردی بنووسە.',
        'name_ar.required'     => 'تکایە ناوی پۆل  بە عەرەبی بنووسە.',
        'name_en.required'     => 'تکایە ناوی پۆل بە ئینگلیزی بنووسە.',
        'image'    => 'تکایە وێنەی پۆل هەلبژێرە.',
        'image.image'          => 'پەڕگەی هەڵبژێردراو دەبێت وێنە بێت.',
        'image.mimes'          => 'جۆری وێنە دەبێت jpeg, png, jpg یان gif بێت.',
        'image.max'            => 'قەبارەی وێنە نابێت لە 2MB زیاتر بێت.',
        'category_id.required' => 'تکایە پۆلێکی سەرەکی هەلبژێرە.',
        'category_id.exists'   => 'پۆلی سەرەکی هەلبژێردراو نەدۆزرایەوە.',
    ];
}
}
