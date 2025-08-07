<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Trait\DeleteFile;
use App\Trait\UploadFile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    use UploadFile;
    use DeleteFile;
    
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Category::query()->latest()->with('user'); // Remove with('user') if not needed
        
         // Advanced search: one input, two columns (e.g., name and description)
        if ($request->filled('custom_search')) {
            $search = $request->custom_search;
            $data->where(function($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%");
            });
        }


        // Add full path to image for DataTables
        return DataTables::of($data)
            ->addColumn('full_path_image', function($row) {
                return $row->image ? 'categories-image/' . $row->image : null; // Assuming images are in public/categories-image
            })
            ->addColumn('created_at_readable', function($row) {
                return $row->created_at->format('H:i:s - Y-m-d'); // Format the created date as needed
            })
            ->addIndexColumn()
            ->make(true);
    }
    return view('admin.categories.index');
}

    
    public function create()
    {
        return view('admin.categories.form');

    }

    
    public function store(CategoryRequest $request)
{
    $new_data = $request->validated();
    $new_data['image'] = $this->Uploadfile($request, 'image', 'categories-image');
    auth()->user()->categories()->create($new_data);
    return redirect()->back()->with(['message' =>  __('words.Category created successfully')]);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::findOrFail($id);
        return view('admin.categories.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Category::findOrfail($id);
        return view('admin.categories.form',compact('data'));}

    /**
     * Update the specified resource in storage.
     */
   public function update(CategoryRequest $request, string $id)
{
    $old_data = Category::findOrFail($id);
    $new_data = $request->validated();
    $name = $old_data->image;

    if ($request->hasFile('image')) {
        // Delete old image from public/categories-image
        if ($old_data->image && file_exists(public_path('categories-image/' . $old_data->image))) {
            unlink(public_path('categories-image/' . $old_data->image));
        }

        // Save new image to public/categories-image
        $name = $request->file('image')->hashName();
        $request->file('image')->move(public_path('categories-image'), $name);
    }

    $new_data['image'] = $name;
    $old_data->update($new_data);

    return redirect()->back()->with(['message' => __('words.Category updated successfully')]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

       $this->DeleteFile(public_path(("categories-image/{$category->image}")));
    
        $category->delete();
        return redirect()->back()->with(['message' => __('words.Category deleted successfully')]);
    }
}
