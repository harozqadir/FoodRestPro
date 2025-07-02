<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Foods;
use App\Models\SubCategory;
use App\Trait\DeleteFile;
use App\Trait\UploadFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FoodController extends Controller
{
    use UploadFile;
    use DeleteFile;
    public function index(Request $request)
    {
    if ($request->ajax()) {
        $data = Foods::latest()->where('sub_category_id',$request->sub_category)->with('user','sub_category'); // Remove with('user') if not needed
        return DataTables::of($data)->addIndexColumn()
            ->make(true);
        }
        $sub_category = SubCategory::findOrFail($request->sub_category);
    return view('admin.foods.index',compact('sub_category'));
}

    
    public function create()
    {

        return view('admin.foods.form');

    }

    
    public function store(FoodRequest $request)
    {
        auth()->user()->foods()->create($request->validated());
        return redirect()->back()->with(['message' => 'User Created Successfully'],);
        

   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = SubCategory::findOrFail($id);
        return view('admin.foods.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Foods::findOrfail($id);

        return view('admin.foods.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodRequest $request, string $id)
    {
         Foods::findOrFail($id)->update($request->validated());
        return redirect()->back()->with(['message' => 'User updated successfully'],);

       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Foods::findOrFail($id)->delete();
        
        return redirect()->back()->with(['message' => 'User deleted successfully'],);
    }
}

