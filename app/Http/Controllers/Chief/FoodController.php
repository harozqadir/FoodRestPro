<?php

namespace App\Http\Controllers\Chief;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Foods;
use App\Models\SubCategory;

class FoodController extends Controller
{
    public function  index()
    { 
        // Fetch all categories
        $categories = Category::all();

        // Eager load subcategories and their foods
        $sub_categories = SubCategory::with('foods')->get();
        
        return view('chief.foods', compact('categories', 'sub_categories'));

    }

    public function update_available($id)
    {
       $food = Foods::findOrFail($id);
         $food->update([
            'is_active' => !$food->is_active
         ]);
         return redirect()->back();
    }
        
}
