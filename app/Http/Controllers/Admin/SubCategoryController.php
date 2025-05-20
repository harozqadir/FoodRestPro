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
           
            $new_data['image'] = $this->Uploadfile($request, 'image', 'sub-categories-image');
            auth()->user()->sub_categories()->create($new_data);
            return redirect()->back()->with(['message' => 'User Created Successfully'],);
            
           // SubCategory::create($validatedData);

       
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
                $this-> DeleteFile(public_path("sub-categories-image/{$name}"));
                // Store the new image
                $name =$this-> UploadFile($request, 'image', 'sub-categories-image');

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
            $sub_category = SubCategory::findOrFail($id);
            $this-> DeleteFile(public_path("sub-categories-image/{$sub_category->image}"));
            $sub_category->delete();
            
            return redirect()->back()->with(['message' => 'User deleted successfully'],);
        }
    }
    

