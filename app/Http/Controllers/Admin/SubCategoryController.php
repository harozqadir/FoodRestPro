<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Trait\DeleteFile;
use Illuminate\Http\Request;
use App\Trait\UploadFile;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    use UploadFile;
    use DeleteFile;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::latest()->with('user', 'category'); // Fetching categories and user relationships
            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('admin.sub-categories.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-categories.form', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        $new_data = $request->validated();

        // Upload the image and store it
        $new_data['image'] = $this->Uploadfile($request, 'image', 'sub-categories-image');
        
        // Create a new subcategory for the authenticated user
        auth()->user()->sub_categories()->create($new_data);

        return redirect()->back()->with(['message' => 'Sub Category Created Successfully']);
    }

    public function show(string $id)
    {
        $data = SubCategory::findOrFail($id);
        return view('admin.sub-categories.show', compact('data'));
    }

    public function edit(string $id)
    {
        $data = SubCategory::findOrFail($id);
        $categories = Category::all();
        return view('admin.sub-categories.form', compact('data', 'categories'));
    }

    public function update(SubCategoryRequest $request, string $id)
    {
        $old_data = SubCategory::findOrFail($id);
        $new_data = $request->validated();
        $name = $old_data->image;

        // If there's a new image, upload and replace the old one
        if ($request->hasFile('image')) {
            // Delete the old image from storage if it exists
            if ($old_data->image && file_exists(public_path('sub-categories-image/' . $old_data->image))) {
                unlink(public_path('sub-categories-image/' . $old_data->image));
            }

            // Upload the new image
            $name = $request->file('image')->hashName();
            $request->file('image')->move(public_path('sub-categories-image'), $name);
        }

        // Update the subcategory data
        $new_data['image'] = $name;
        $old_data->update($new_data);

        return redirect()->back()->with(['message' => 'Sub Category Updated Successfully']);
    }

    public function destroy(string $id)
    {
        $sub_category = SubCategory::findOrFail($id);

        // Delete the image from storage
        $this->DeleteFile(public_path("sub-categories-image/{$sub_category->image}"));

        // Delete the subcategory record
        $sub_category->delete();

        return redirect()->back()->with(['message' => 'Sub Category Deleted Successfully']);
    }
}
