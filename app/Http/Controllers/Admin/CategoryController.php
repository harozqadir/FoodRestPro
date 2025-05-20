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
        $data = Category::latest()->with('user'); // Remove with('user') if not needed
        return DataTables::of($data)->addIndexColumn()
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

        $new_data=$request->validated();
        
        $new_data['image'] = $this->Uploadfile($request, 'image', 'categories-image');
        auth()->user()->categories()->create($new_data);
        return redirect()->back()->with(['message' => 'User Created Successfully'],);
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
        $name= $old_data->image;
        if ($request->hasFile('image')) {
            //If the image is updated, delete the old image
            if ($old_data->image != null) {
                $name = $old_data->image;
            }
            // Check if the old image file exists and delete it
            if (file_exists(public_path('categories-image/' . $old_data->image))) {
                unlink(public_path('categories-image/' . $old_data->image));
            }
            // Store the new image
            $name = $request->file('image')->hashName();
            $request->file('image')->move('categories-image', $name);
        }
        $new_data['image'] = $name;
        $old_data->update($new_data);
        return redirect()->back()->with(['message' => 'User updated successfully'],);

       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

       $this->DeleteFile(public_path(("categories-image/{$category->image}")));
    
        $category->delete();
        return redirect()->back()->with(['message' => 'User deleted successfully'],);
    }
}
