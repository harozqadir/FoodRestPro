<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
          'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'hour' => 'required',
        'chair' => 'required|integer|min:1',
        'table_id' => 'required|exists:tables,id',
        'user_id' => 'required|exists:users,id',

        ];
    }
    public function messages()
{
    return [
        'name.required'          => 'تکایە ناوی میوان بنووسە.',
        'name.string'            => 'ناو دەبێت نووسراو بێت.',
        'name.max'               => 'ناو نابێت لە ٢٥٥ پیت زیاتر بێت.',
        'phone_number.required'  => 'تکایە ژمارەی مۆبایل بنووسە.',
        'phone_number.string'    => 'ژمارەی مۆبایل دەبێت نووسراو بێت.',
        'phone_number.max'       => 'ژمارەی مۆبایل نابێت لە ٢٠ پیت زیاتر بێت.',
        'hour.required'          => 'تکایە کات هەلبژێرە.',
        'chair.required'         => 'تکایە ژمارەی کورسی بنووسە.',
        'chair.integer'          => 'ژمارەی کورسی دەبێت ژمارە بێت.',
        'chair.min'              => 'ژمارەی کورسی دەبێت لە ١ زیاتر بێت.',
        'table_id.required'      => 'تکایە خشتە هەلبژێرە.',
        'table_id.exists'        => 'خشتەی هەلبژێردراو نەدۆزرایەوە.',
        'user_id.required'       => 'تکایە بەکارهێنەر هەلبژێرە.',
        'user_id.exists'         => 'بەکارهێنەری هەلبژێردراو نەدۆزرایەوە.',
    ];
}
    
}
