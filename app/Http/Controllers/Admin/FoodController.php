<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Category;
use App\Models\Foods;
use App\Models\SubCategory;
use App\Trait\DeleteFile;
use App\Trait\UploadFile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FoodController extends Controller
{
    /**
     * Display the foods list for admin.
     */
    use DeleteFile;
    use UploadFile;
    
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Foods::with('category', 'sub_category', 'user')->select('foods.*');

        if ($request->has('sub_category_id') && $request->sub_category_id != '') {
            $data->where('sub_category_id', $request->sub_category_id);
        }
        if ($request->has('is_active') && $request->is_active != '') {
            $data->where('is_active', $request->is_active);
        }
        if ($request->has('global_search') && $request->global_search != '') {
            $search = $request->global_search;
            $data->where(function($q) use ($search) {
                $q->where('name_ckb', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
            });
        }

        return DataTables::of($data)
            ->addIndexColumn()
             ->addColumn('full_path_image', function($row) {
                    return $row->image ? 'foods-image/' . $row->image : null; // Assuming images are in public/sub-categories-image
                })
            ->editColumn('sub_category_id', function ($food) {
                return $food->sub_category->name_en;
            })
            // Add other columns as needed
            ->make(true);
    }

    return view('admin.foods.index', [
        'sub_categories' => SubCategory::all(),
    ]);
}

    /**
     * Show the form to create a new food item.
     */
    public function create()
    {
        // Get all sub-categories for the form
        $sub_categories = SubCategory::all();

        // Return the form view with sub-categories
        return view('admin.foods.form', compact('sub_categories'));
    }

    /**
     * Store a newly created food item in the database.
     */
    public function store(FoodRequest $request)
    {
         $new_data = $request->validated();
           
             $new_data['image'] = $this->Uploadfile($request, 'image', 'foods-image');

        // Create a new food item for the authenticated user
        auth()->user()->foods()->create($new_data);

        // Redirect back with a success message
        return redirect()->back()->with(['message' => __('words.Food created successfully')]);
    }

    /**
     * Show the form to edit a specific food item.
     */
    public function show(string $id)
    {
        $data = Foods::findOrFail($id);
        return view('admin.foods.show', compact('data'));
    }
    public function edit(string $id)
    {
        // Find the food item by ID
        $data = Foods::findOrFail($id);

        // Get all sub-categories for the form
        $sub_categories = SubCategory::all();

        // Return the form view with food item data and sub-categories
        return view('admin.foods.form', compact('data', 'sub_categories'));
    }

    /**
     * Update the specified food item in storage.
     */
    public function update(FoodRequest $request, string $id)
    {
          $old_data = Foods::findOrFail($id);
        $new_data = $request->validated();
        $name = $old_data->image;

        // If there's a new image, upload and replace the old one
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists
            if ($old_data->image && file_exists(public_path('foods-image/' . $old_data->image))) {
                unlink(public_path('foods-image/' . $old_data->image));
            }

            // Upload the new image
            $name = $request->file('image')->hashName();
            $request->file('image')->move(public_path('foods-image'), $name);
        }
         // Update the subcategory data
        $new_data['image'] = $name;
        $old_data->update($new_data);

        // Find and update the food item
        $old_data = Foods::findOrFail($id)->update($request->validated());

        // Redirect back with an update success message
        return redirect()->back()->with(['message' =>__('words.Food updated successfully')]);
    }

    /**
     * Remove the specified food item from storage.
     */
    public function destroy(string $id)
    {
           
        $foods = Foods::findOrFail($id);
         // Delete the image from storage
        $this->DeleteFile(public_path("foods-image/{$foods->image}"));


        // Find and delete the food item
        Foods::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with(['message' => __('words.Food deleted successfully')]);
    }
}
