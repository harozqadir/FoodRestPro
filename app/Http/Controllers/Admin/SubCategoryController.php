<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    
        public function index(Request $request)
        {
        if ($request->ajax()) {
            $data = SubCategory::latest()->with('user','category'); // Remove with('user') if not needed
            return DataTables::of($data)->addIndexColumn()
                ->make(true);
            }
        return view('admin.sub-categories.index');
    }
    
        
        public function create()
        {
             $categories = Category::all();

            return view('admin.sub-categories.form',compact('categories'));
    
        }
    
        
        public function store(SubCategoryRequest $request)
        {
            $new_data=$request->validated();
            $name= $request->file('image')->hashName();
            $request->file('image')->move('sub-categories-image', $name);
            $new_data['image'] = $name;
            auth()->user()->sub_categories()->create($new_data);
            return redirect()->back()->with(['message' => 'User Created Successfully'],);
            
            SubCategory::create($validatedData);

       
        }
    
        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $data = SubCategory::findOrFail($id);
            return view('admin.sub-categories.show', compact('data'));
        }
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $data = SubCategory::findOrfail($id);
            $categories = Category::all();

            return view('admin.sub-categories.form',compact('data','categories'));}
    
        /**
         * Update the specified resource in storage.
         */
        public function update(SubCategoryRequest $request, string $id)
        {
            $old_data = SubCategory::findOrFail($id);
            $new_data = $request->validated();
            $name= $old_data->image;
            if ($request->hasFile('image')) {
                //If the image is updated, delete the old image
                if ($old_data->image != null) {
                    $name = $old_data->image;
                }
                // Check if the old image file exists and delete it
                if (file_exists(public_path('sub-categories-image/' . $old_data->image))) {
                    unlink(public_path('sub-categories-image/' . $old_data->image));
                }
                // Store the new image
                $name = $request->file('image')->hashName();
                $request->file('image')->move('sub-categories-image', $name);
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
            $category = SubCategory::findOrFail($id);
            $file=public_path("sub-categories-image/{$category->image}");
            if (file_exists($file)) {
                unlink($file);
            }
            $category->delete();
            return redirect()->back()->with(['message' => 'User deleted successfully'],);
        }
    }
    

