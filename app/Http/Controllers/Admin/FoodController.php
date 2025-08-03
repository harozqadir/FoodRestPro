<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Category;
use App\Models\Foods;
use App\Models\SubCategory;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FoodController extends Controller
{
    /**
     * Display the foods list for admin.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        // Start the query with necessary relationships
        $data = Foods::with('category', 'sub_category', 'user')
            ->select('foods.*');

        // Apply filters if they are provided in the request
        if ($request->has('sub_category_id') && $request->sub_category_id != '') {
            $data->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('is_active') && $request->is_active != '') {
            $data->where('is_active', $request->is_active);
        }

        if ($request->has('price_min') && $request->price_min != '') {
            $data->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max') && $request->price_max != '') {
            $data->where('price', '<=', $request->price_max);
        }

        // Fetch data and return to DataTables
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('sub_category_id', function ($food) {
                return $food->sub_category->name_en;
            })
            ->make(true);
    }

    // Return the foods index view
    return view('admin.foods.index', [
        'sub_categories' => SubCategory::all(), // Pass sub-categories for filtering
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
        // Create a new food item for the authenticated user
        auth()->user()->foods()->create($request->validated());

        // Redirect back with a success message
        return redirect()->back()->with(['message' => 'Food Created Successfully']);
    }

    /**
     * Show the form to edit a specific food item.
     */
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
        // Find and update the food item
        $old_data = Foods::findOrFail($id)->update($request->validated());

        // Redirect back with an update success message
        return redirect()->back()->with(['message' => 'Food updated successfully']);
    }

    /**
     * Remove the specified food item from storage.
     */
    public function destroy(string $id)
    {
        // Find and delete the food item
        Foods::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with(['message' => 'Food deleted successfully']);
    }
}
