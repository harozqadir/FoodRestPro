<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
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
            'sub_category_id' => 'required|exists:sub_categories,id|numeric', 
           // 'table_id' => 'required|exists:tables,id|numeric',
            'price'=> 'required|numeric',
            // 'foods' => 'required|array',
            // 'foods.*.id' => 'required|exists:foods,id',
            // 'foods.*.quantity' => 'required|integer|min:1',
            // 'foods.*.price' => 'required|numeric|min:0',
            // 'total' => 'required|numeric|min:0',
        ];

        // Example: Only require 'total' for casher
//     if (auth()->user()->isCasher()) {
//         $rules['total'] = 'required|numeric';
//     }

//     return $rules;
// }
    }
}
